<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\QuestionAnswersResource;
use App\Http\Resources\QuestionOptionResource;
use App\Http\Resources\QuestionTypeResource;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionType;
use App\Models\Question_option;
use App\Models\SubOption;
use App\Models\SubQuestion;
use App\Models\SubQuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends BaseController
{

    public function questionlist(Request $request)
    {

        try {

            if(isset($request->language_code) && !empty($request->language_code)){

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
                $questionData = $questions->map(function ($question) use ($request){
                    return [
                        'id' => $question->id,
                        'questionType_id' => $question->questionType_id,
                        'question_name' => $question['question_name_' . $request->language_code],
                        'options' => QuestionOptionResource::collection($question->options),
                        'age_group' => isset($question->age_group) ? [
                            'id' => $question->age_group->id,
                            'name' => $question->age_group->name,
                        ] : null,
                    ];
                });

                return $this->sendResponse($questionData, 'Question list retrieved successfully.', true);
            }else{
                return $this->sendResponse(null, 'Language Code Not Found!', false);
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function questionTypeList(Request $request)
    {

        try {
            if(isset($request->language_code) && !empty($request->language_code)){
                $questionType = QuestionType::all();
                $questionTypeData = QuestionTypeResource::collection($questionType);

                return $this->sendResponse($questionTypeData, 'QuestionType list retrived successfully.', true);
            }else{
                return $this->sendResponse(null, 'Language Code Not Found!', false);
            }
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
                        'question_option_id' => $question_option_ids[$index],
                        'pms' => $request->pms,
                        'pco' => $request->pco,
                        'anemia' => $request->anemia,
                    ];

                    $question_answer = QuestionAnswer::where('user_id', $user_id)
                        ->where('question_id', $question_id)
                        ->first();

                    QuestionAnswer::create($input);

                }

                return $this->sendResponse([], 'Question answers have been submitted successfully.', true);
            } else {
                return $this->sendResponse(null, 'User not found or question/option ids are missing.!', false);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }

    public function getQuestionAnswers()
    {
        try {
            $currentMonth = date('m');
            $currentYear = date('Y');

            $user_id = Auth::user() ? Auth::user()->id : "";
            if (!empty($user_id)) {
                $question_answers = QuestionAnswer::where('user_id', $user_id)
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->get();

                $question_answer_pms = QuestionAnswer::where('user_id', $user_id)
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->whereNotNull('pms')
                    ->first();

                $question_answer_pco = QuestionAnswer::where('user_id', $user_id)
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->whereNotNull('pco')
                    ->first();

                $question_answer_anemia = QuestionAnswer::where('user_id', $user_id)
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear)
                    ->whereNotNull('anemia')
                    ->first();

                $pms = $question_answer_pms ? $question_answer_pms->pms : null;
                $pco = $question_answer_pco ? $question_answer_pco->pco : null;
                $anemia = $question_answer_anemia ? $question_answer_anemia->anemia : null;

                // Transform the collection of question answers into a resource
                $data = new QuestionAnswersResource($question_answers);

                // Construct the response array
                $response = [
                    'data' => $data,
                    'pms' => $pms,
                    'pco' => $pco,
                    'anemia' => $anemia,
                    'message' => 'Question Answers have been Fetched.',
                    'success' => true,
                ];

                return response()->json($response);

                // return $this->sendResponse($data, 'Question Answers has been Fetched.', true);
            } else {
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

    public function getSubQuestions(Request $request)
    {
       
        try {
            $option_id = $request->option_id;
           
            if (isset($option_id) && !empty($option_id) && isset($request->language_code) && !empty($request->language_code)) {
               
                $sub_options = SubQuestion::where('sub_option_id', $option_id)->orWhere('option_id', $option_id)->with('sub_question')->get();

                $data = [];
                if (count($sub_options) > 1) {
                    foreach ($sub_options as $key => $sub_option) {
                        dd($sub_option->sub_question->title_($request->language_code));
                        if ($sub_option->question_or_notification != "question") {
                            $data['notification_id'] = isset($sub_option->id) ? $sub_option->id : null;
                            $data['notification'] = isset($sub_option->sub_question) ? $sub_option->sub_question['title_'. $request->language_code] : null;
    
                        } else {
                            $options_of_question = SubOption::select('id', 'option_name_'. $request->language_code)->where('question_or_notification_id', $sub_option->sub_question_id)->get();
                            $data['question_id'] = isset($sub_option->id) ? $sub_option->id : null;
                            $data['question'] = isset($sub_option->sub_question) ? $sub_option->sub_question['title_'. $request->language_code] : null;
                            $data['options'] = isset($options_of_question) ? $options_of_question : null;
                        }
                    }
                    $sub_questions = $data;
                } else {
                    if (count($sub_options) > 0) {
                        foreach ($sub_options as $key => $sub_option) {
                            if ($sub_option->question_or_notification != "question") {
                                $data['notification_id'] = isset($sub_option->id) ? $sub_option->id : null;
                                $data['notification'] = isset($sub_option->sub_question) ? $sub_option->sub_question['title_'. $request->language_code] : null;
                                $data['question'] = null;
                                $data['options'] = null;
                            } else {
                                $options_of_question = SubOption::select('id', 'option_name_'. $request->language_code)->where('question_or_notification_id', $sub_option->sub_question_id)->get();
                                $data['notification'] = null;
                                $data['question_id'] = isset($sub_option->id) ? $sub_option->id : null;
                                $data['question'] = isset($sub_option->sub_question) ? $sub_option->sub_question['title_'. $request->language_code] : null;
                                $data['options'] = isset($options_of_question) ? $options_of_question : null;
                            }
                        }
                        $sub_questions = $data;
                    } else {
                        $sub_questions = null;
                    }
                }
    
                return $this->sendResponse($sub_questions, 'Data Receive Successfully', true);
     
            }else{

                return $this->sendResponse(null, 'Required Parameter Not Found!', false);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'something went wrong!', false);
        }
    }

    public function subQuestionAnswer(Request $request)
    {
        try {

            $user_id = Auth::id();

            if (!empty($user_id) && isset($request->sub_question_ids) && isset($request->sub_option_ids)) {
                $sub_question_ids = $request->sub_question_ids;
                $sub_option_ids = $request->sub_option_ids;

                // Validate if both arrays have the same length
                if (count($sub_question_ids) !== count($sub_option_ids)) {
                    return $this->sendResponse(null, 'Question ids and option ids array length mismatch.', false);
                }

                foreach ($sub_question_ids as $index => $sub_question_id) {

                    $input = [
                        'user_id' => $user_id,
                        'sub_question_id' => $sub_question_id,
                        'sub_option_id' => $sub_option_ids[$index],
                    ];

                    $question_answer = SubQuestionAnswer::where('user_id', $user_id)
                        ->where('sub_question_id', $sub_question_id)
                        ->first();

                    if ($question_answer) {
                        $question_answer->update($input);
                    } else {
                        SubQuestionAnswer::create($input);
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
}
