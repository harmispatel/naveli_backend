<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionType;
use App\Models\QuestionTypeAge;
use App\Models\Question_option;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;


class QuestionController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('permission:question.index|question.create|question.edit|question.destroy|question.optionView', ['only' => ['index', 'store']]);
        $this->middleware('permission:question.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:question.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:question.destroy', ['only' => ['delete']]);
        $this->middleware('permission:question.optionView', ['only' => ['questionOptionView']]);
    }

    public function index(Request $request)
    {
        try {

            $questionTypes = QuestionType::all();
            $ageGroups = QuestionTypeAge::all();

            if ($request->ajax()) {
                $questions = Question::query();

                // Filter by age group
                if ($request->has('age_group_filter') && !empty($request->age_group_filter)) {
                    $questions->where('age_group_id', $request->age_group_filter);
                }

                // Filter by question type
                if ($request->has('question_type_filter') && !empty($request->question_type_filter)) {
                    $questions->where('questionType_id', $request->question_type_filter);
                }

                $allQuestions = $questions->get();

                return DataTables::of($allQuestions)
                    ->addIndexColumn()
                    ->addColumn('questionType_id', function ($question) {
                        $questionType = QuestionType::find($question->questionType_id);
                        return $questionType ? $questionType->name_en : '--';
                    })
                    ->addColumn('age_group_id', function ($question) {
                        $ageGroup = QuestionTypeAge::find($question->age_group_id);
                        return $ageGroup ? $ageGroup->name : '--';
                    })
                    ->addColumn('actions', function ($question) {

                        $action_html = '<div class="btn-group">';
                        $action_html .= '<a href=' . route("question.edit", ["id" => encrypt($question->id) , "locale" => "hi"]) . ' class="btn btn-sm custom-btn me-1"> <i class="bi bi-pencil" aria-hidden="true"></i></a>';
                        if(!in_array($question->questionType_id, [1, 2, 3, 4])){
                            $action_html .= '<a onclick="deleteUsers(\'' . $question->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>';
                        }
                        $action_html .= '<a href=' . route("question.optionView", ["id" => encrypt($question->id)]) . ' class="btn btn-sm btn-info me-1"><i class="bi bi-eye" aria-hidden="true"></i></a>';
                        $action_html .= '</div>';
                        return $action_html;
                    })
                    ->rawColumns(['actions', 'questionType_id'])
                    ->make(true);
            }

            return view('admin.questions.index',compact('ageGroups','questionTypes'));
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Internal Server Error');
        }
    }


    public function questionOptionView($id)
    {
        try {
            $id = decrypt($id);
            $options = Question_option::where('question_id', $id)->get();

            $question = Question::where('id',$id)->first();

            return view('admin.questions.OptionView', compact('options','question'));
        } catch (\Throwable $th) {

            return redirect()->back()->with('error', 'Internal Server Error');
        }
    }

    public function create()
    {
        $questionTypes = QuestionType::get();
        $ageTypes = QuestionTypeAge::get();
        // $options = $this->optionViewType();

        return view('admin.questions.create', compact('questionTypes','ageTypes'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'question_name_en' => 'required',
            'questionType_id' => 'required',
        ]);

        try {
            $input = $request->except('_token', 'option_name','age_group_id');

            if($request->has('age_group_id') && $request->questionType_id == 3){
                $input['age_group_id'] = $request->age_group_id;
            }

            $question = Question::create($input);

            if ($request->has('option_name')) {
                $optionNames = $request->option_name;

                // Check if $optionNames and $icons are arrays before using count()
                if (is_array($optionNames) && count($optionNames)) {
                    foreach ($optionNames as $index => $optionName) {
                        // Check if $optionName is not null or an empty string
                        if ($optionName !== null && $optionName !== '') {
                            $questionOption = new Question_option;
                            $questionOption->question_id = $question->id;
                            $questionOption->option_name_en = $optionName;
                            $questionOption->option_slug = strtolower(Str::slug($questionOption->option_name_en, "_"));
                            $questionOption->save();
                        }
                    }
                }
            }

            // return redirect()->route('question.index')->with('message', 'Question Saved Successfully');
            return redirect()->route('question.index')->with('message', 'Question Saved Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('question.index')->with('error', 'Internal Server Error');
        }
    }

    public function edit($id,$def_locale)
    {
        try {
            $id = decrypt($id);
            // $age_views = $this->optionViewType();
            $question = Question::find($id);
            $options = Question_option::where('question_id', $id)->get();
            $questionTypes = QuestionType::get();
            $ageTypes = QuestionTypeAge::get();

            return view('admin.questions.edit', compact('question','ageTypes', 'options', 'questionTypes','def_locale'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Internal Server Error');
        }

    }

    public function update(Request $request)
    {
        $request->validate([
            'question_name' => 'required',
            'language_code' => 'required',
            'option_name.*' => 'required'
        ]);

        try {
            $id = decrypt($request->id);
            $question = Question::find($id);

            if (!$question) {
                return redirect()->route('question.index')->with('error', 'Question Not Found');
            }

            // Update the question name based on the language code
            $question->{'question_name_' . $request->language_code} = $request->question_name;
            $question->save();

            // If the language code is 'hi', update the option names as well
            if ($request->language_code == 'hi') {
                $existingOptionIds = [];

                // Retrieve existing question options
                $questionOptions = Question_option::where('question_id', $id)->get();

                // Check if the number of provided option names matches the number of existing options
                if (count($request->option_name) != $questionOptions->count()) {
                    return redirect()->route('question.index')->with('error', 'The number of options provided does not match the number of existing options.');
                }

                foreach ($request->option_name as $index => $optionName) {
                    if (!is_null($optionName)) {
                        $questionOption = $questionOptions[$index];
                        $questionOption->update([
                            'option_name_hi' => $optionName,
                        ]);
                        $existingOptionIds[] = $questionOption->id;
                    }
                }
            }

            return redirect()->route('question.index')->with('message', 'Question Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('question.index')->with('error', 'Internal Server Error');
        }
    }


//     public function update(Request $request)
// {
//     $request->validate([
//         'question_name' => 'required',
//         'questionType_id' => 'required',
//         'image' => 'mimes:jpeg,png,bmp,tiff,jpg|max:4096',
//         'icon.*' => 'mimes:jpeg,png,bmp,tiff,jpg|max:4096',

//     ]);

//     try {
//         $id = decrypt($request->id);

//         $question = Question::find($id);

//         if (!$question) {
//             return redirect()->route('question.index')->with('error', 'Question Not Found');
//         }

//         // Begin a transaction
//         DB::beginTransaction();

//         $question->questionType_id = $request->questionType_id;
//         $question->question_name = $request->question_name;

//         if ($request->hasFile('image')) {
//             $file = $request->file('image');
//             $image_url = $this->addSingleImage('question', $file, $question->image);
//             $question->image = $image_url;
//         } elseif (!$request->hasFile('image') && !$request->input('remove_image')) {
//             // If the image input field is blank and remove_image is not set, retain the existing image
//             $question->image = $question->image;
//         } else {
//             // If there was no existing image and no new image uploaded, set the image attribute to null
//             $question->image = null;
//         }

//         $question->save();

//         $optionData = Question_option::where('question_id', $id)->get();
//         $existingOptionIds = [];

//         if ($request->has('option_name') || $request->hasFile('icon')) {
//             $optionNames = $request->option_name;
//             $icons = $request->file('icon');

//             foreach ($optionNames as $index => $optionName) {
//                 // Find existing Question_option or create a new one
//                 $questionOption = $optionData->get($index) ?? new Question_option;

//                 if (!is_null($optionName) && (!isset($icons) || is_null($icons) || !isset($icons[$index]) || $icons[$index]->isValid()) || $questionOption->exists) {
//                     if (isset($icons) && !is_null($icons) && isset($icons[$index]) && $icons[$index]->isValid()) {
//                         $icon = $icons[$index];
//                         $iconName = $icon->getClientOriginalName();
//                         $icon->move(public_path('images/uploads/question_option'), $iconName);
//                         $questionOption->icon = $iconName;
//                     }

//                     $questionOption->question_id = $id;
//                     $questionOption->option_name = $optionName;
//                     $questionOption->save();

//                     if ($questionOption->exists) {
//                         $existingOptionIds[] = $questionOption->id;
//                     }
//                 }
//             }
//         }

//         Question_option::where('question_id', $id)
//             ->whereNotIn('id', $existingOptionIds)
//             ->delete();

//         // Commit the transaction
//         DB::commit();

//         return redirect()->route('question.index')->with('message', 'Data Updated Successfully');
//     } catch (\Throwable $th) {
//         // Rollback the transaction on error
//         DB::rollBack();

//         // Log the error for further investigation
//         return redirect()->route('question.index')->with('error', 'Internal Server Error');
//     }
// }

    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            $question = Question::find($id);
            $question->delete();

            return response()->json([
                'success' => 1,
                'message' => "QuestionType deleted Successfully..",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

    }

}
