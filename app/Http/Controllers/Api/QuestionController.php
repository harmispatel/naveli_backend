<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\QuestionAnswersResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionOptionResource;
use App\Http\Resources\QuestionTypeResource;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\QuestionAnswer;
use App\Models\Question_option;
use App\Models\SubOption;
use App\Models\SubQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends BaseController
{

    // public function questionlist(Request $request)
    // {
    //     try {
    //         $offset = isset($request->offset) ? $request->offset : 0;
    //         $question = Question::with('options');

    //         if (isset($request->age_group_id) && !empty($request->age_group_id)) {
    //             $question = $question->where('age_group_id', $request->age_group_id);
    //         }

    //         if (isset($request->role_id) && !empty($request->role_id)) {
    //             $question = $question->where('role_id', $request->role_id);
    //         }

    //         if (isset($request->option_view_type) && !empty($request->option_view_type)) {
    //             $question = $question->where('option_view_type', $request->option_view_type);
    //         }

    //         $question = $question->offset($offset)->limit(10)->get();
    //         $questionData = QuestionResource::collection($question);

    //         return $this->sendResponse($questionData, 'Question list retrieved successfully.', true);
    //     } catch (\Throwable $th) {
    //         return $this->sendError('Something Went Wrong!', [], 500);
    //     }
    // }

    public function questionlist(Request $request)
    {
        try {
            $questionType = isset($request->question_type) ? $request->question_type : 0;
            $ageGroup = $request->age_group ?? null;

            $questionsQuery = Question::where('questionType_id', $questionType)
            ->with('options', 'age_group');

            if ($questionType == 3 && !$ageGroup) {
                return $this->sendResponse(null, 'Age group is required for question type Others.', false);
            }

            if ($ageGroup) {
                $questionsQuery->whereHas('age_group', function ($query) use ($ageGroup) {
                    $query->where('name', $ageGroup);
                });
            }

        $questions = $questionsQuery->get();
            $questionData = $questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'questionType_id' => $question->questionType_id,
                    'question_name' => $question->question_name,
                    'options' => QuestionOptionResource::collection($question->options),
                    'age_group' => isset($question->age_group) ? [
                        'id' => $question->age_group->id,
                        'name' => $question->age_group->name
                    ] : null,
                ];
            });

            return $this->sendResponse($questionData, 'Question list retrieved successfully.', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function questionTypeList(Request $request)
    {

        try {
            $questionType = QuestionType::get();
            $questionTypeData = QuestionTypeResource::collection($questionType);

            return $this->sendResponse($questionTypeData, 'QuestionType list retrived successfully.', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $Question = Question::find($id);

            if (!$Question) {
                return $this->sendError('Question not found!', [], 404);
            }

            $QueImg = $Question->image;

            if (!empty($QueImg) && file_exists(public_path('images/uploads/question/' . $QueImg))) {
                unlink(public_path('images/uploads/question/' . $QueImg));
            }

            $QueOptions = Question_option::where('question_id', $Question->id)->get();

            foreach ($QueOptions as $option) {
                $icon = $option->icon;

                if (!empty($icon) && file_exists(public_path('images/uploads/question_option/' . $icon))) {
                    unlink(public_path('images/uploads/question_option/' . $icon));
                }
                $option->delete();
            }

            $DeleteQuestion = $Question->delete();

            return $this->sendResponse($DeleteQuestion, 'Data Deleted SuccessFully!', true);
        } catch (\Throwable $th) {
            return $this->sendError('Something Went Wrong!', [], 500);
        }
    }

    // public function questionAnswer(Request $request)
    // {
    //     try {
    //         $user_id = Auth::user() ? Auth::user()->id : "";
    //         if (isset($request->question_id) && !empty($request->question_id) && isset($request->option_id) && !empty($request->option_id)) {
    //             if(!empty($user_id)){
    //                 $input = $request->except(['_token', 'option_id']);
    //                 $input['user_id'] = $user_id;
    //                 $input['question_option_id'] = $request->option_id;
    //                 $question_answer = QuestionAnswer::where('user_id', $user_id)->where('question_id', $request->question_id)->first();
    //                 $answer_id = (isset($question_answer->id)) ? $question_answer->id : "";

    //                 if(!empty($answer_id)){
    //                     $edit_data = QuestionAnswer::find($answer_id);
    //                     $edit_data->question_option_id = $request->option_id;
    //                     $edit_data->update();
    //                 }else{
    //                     QuestionAnswer::create($input);
    //                 }
    //                 return $this->sendResponse([], 'Question answer has been Submited.', true);
    //             }else{
    //                 return $this->sendError('User not Found!.', [], 404);
    //             }
    //         } else {
    //             return $this->sendError('all Fields are required!', [], 404);
    //         }
    //     } catch (\Throwable $th) {
    //         return $this->sendError('Something Went Wrong.', [], 500);
    //     }
    // }

    public function questionAnswer(Request $request)
    {
        try {

            $user_id = Auth::id(); // Simplified way to get user id using Auth::id()

            if (!empty($user_id) && isset($request->question_ids) && isset($request->question_option_ids)) {
                $question_ids = $request->question_ids;
                $question_option_ids = $request->question_option_ids;

                // Validate if both arrays have the same length
                if (count($question_ids) !== count($question_option_ids)) {
                    return $this->sendResponse(null, 'Question ids and option ids array length mismatch.', false);
                }

                foreach ($question_ids as $index => $question_id) {

                    $input = [
                        'user_id' => $user_id,
                        'question_id' => $question_id,
                        'question_option_id' => $question_option_ids[$index]
                    ];

                    $question_answer = QuestionAnswer::where('user_id', $user_id)
                        ->where('question_id', $question_id)
                        ->first();

                    if ($question_answer) {
                        $question_answer->update($input);
                    } else {
                        QuestionAnswer::create($input);
                    }
                }

                return $this->sendResponse([], 'Question answers have been submitted successfully.', true);
            } else {
                return $this->sendResponse(null, 'User not found or question/option ids are missing.!', false);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }


    public function getQuestionAnswers(){
        try {
            $user_id = Auth::user() ? Auth::user()->id : "";
            if(!empty($user_id)){
                $question_answers = QuestionAnswer::where('user_id', $user_id)->get();
                $data = new QuestionAnswersResource($question_answers);
                return $this->sendResponse($data, 'Question Answers has been Fetched.', true);
            }else{
                return $this->sendError('User not Found!.', [], 404);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Something Went Wrong.', [], 500);
        }
    }

    //     public function destroyy(Request $request)
    // {
    //     $id = $request->id;

    //     try {
    //         // Find the question
    //         $question = Question::find($id);

    //         if (!$question) {
    //             return $this->sendError('Question not found', [], 404);
    //         }

    //         // Delete the question's image
    //         $questionImage = $question->image;

    //         if (!empty($questionImage) && file_exists(public_path('images/uploads/question/' . $questionImage))) {
    //             unlink(public_path('images/uploads/question/' . $questionImage));
    //         }

    //         // Delete associated options and their images
    //         $questionOptions = Question_option::where('question_id', $question->id)->get();

    //         foreach ($questionOptions as $option) {
    //             $optionIcon = $option->icon;

    //             if (!empty($optionIcon) && file_exists(public_path('images/uploads/question_option/' . $optionIcon))) {
    //                 unlink(public_path('images/uploads/question_option/' . $optionIcon));
    //             }

    //             $option->delete(); // Delete the option
    //         }

    //         // Finally, delete the question
    //         $question->delete();

    //         return $this->sendResponse(null, 'Data Deleted Successfully!');
    //     } catch (\Throwable $th) {
    //         return $this->sendError('Something Went Wrong!', [], 500);
    //     }
    // }
        public function getSubQuestions(Request $request){
            try {

                $option_id = $request->option_id;

                if($option_id){
                    $getSubQuestions = SubQuestion::where('sub_option_id',$option_id)->orWhere('option_id',$option_id)->with('sub_question')->get();
                }else{
                    return $this->sendResponse(null, 'Option Id Not Found!', false);
                }

                if(isset($getSubQuestions)){

                    $subQuestions = $getSubQuestions->map(function($getSubQuestion){

                        if($getSubQuestion->question_or_notification != "question"){
                            return  [
                                        'Notification' => isset($getSubQuestion->sub_question) ?
                                            $getSubQuestion->sub_question->title
                                        : null,
                                        "Question" => null,
                                        "Options" => null
                                    ];
                        }else{
                            $options_of_question = SubOption::select('id','option_name')->where('question_or_notification_id',$getSubQuestion->sub_question_id)->get();
                            return  [
                                        "Notification" => null,
                                        'Question' => isset($getSubQuestion->sub_question) ?
                                            $getSubQuestion->sub_question->title
                                        : null,
                                        "Options" => isset($options_of_question) ?
                                            $options_of_question : null
                                    ];
                        }

                    });
                    return $this->sendResponse($subQuestions, 'Data Receive Successfully', true);
                }

            } catch (\Throwable $th) {
                return $this->sendResponse(null, 'something went wrong!', false);
            }
        }
}
