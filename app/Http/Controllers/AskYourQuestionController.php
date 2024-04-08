<?php

namespace App\Http\Controllers;

use App\Models\AskYourQuestion;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AskYourQuestionController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('permission:userAskQuestion.index|userAskQuestion.create|userAskQuestion.edit|userAskQuestion.destroy', ['only' => ['index', 'show']]);
        $this->middleware('permission:userAskQuestion.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:userAskQuestion.destroy', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {
        try {

            if ($request->ajax()) {

                $askquestion = AskYourQuestion::get();

                return DataTables::of($askquestion)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($ask) {
                        return '<div class="btn-group">
                    <a href=' . route("userAskQuestion.edit", ["id" => encrypt($ask->id)]) . ' class="btn btn-sm custom-btn me-1"><i class="bi bi-reply-fill" aria-hidden="true"></i></a>
                    <a onclick="deleteUsers(\'' . $ask->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                    </div>';
                    })
                    ->rawColumns(['actions'])
                    ->make(true);

            }
            return view('admin.askQuestion.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', 'internal server error');
        }
    }

    // public function create()
    // {
    //     return view('admin.askQuestion.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'user_question' => 'required',
    //     ]);

    //     try {

    //         $input = $request->except('_token');
    //         $input['user_id'] = auth()->user()->id;

    //         $askQuestion = AskYourQuestion::create($input);

    //         return redirect()->route('userAskQuestion.index')->with('Message', 'Question added SuccessFully');

    //     } catch (\Throwable $th) {
    //         return redirect()->route('userAskQuestion.index')->with('errors', 'internal server error');
    //     }
    // }

    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $askQuestion = AskYourQuestion::find($id);

            return view('admin.askQuestion.edit', compact('askQuestion'));
        } catch (\Throwable $th) {
            return redirect()->route('userAskQuestion.index')->with('errors', 'internal server error');
        }
    }

    public function update(Request $request)
    {
       
        $request->validate([
            'name' => 'required',
            'user_question' => 'required',
            'image' => 'required',
            'question_answer' => 'required',
            'file_type' => 'required',

        ]);

        try {
            $id = decrypt($request->id);

            $askquestion = AskYourQuestion::find($id);
            $askquestion->name = $request->name;
            $askquestion->user_question = $request->user_question;
            $askquestion->file_type = $request->file_type;
            $askquestion->question_answer = $request->question_answer;

          
            if ($request->file('image')) {
               
                $file = $request->file('image');
                $file_url = $this->addSingleImage('askQuestion', $file, $old_image = '');
                $askquestion->image = $file_url;
            } else {
                $askquestion->image = $request->image;
            }
           
            $askquestion->save();

            return redirect()->route('userAskQuestion.index')->with('Message', 'Question Updated SuccessFully');
        } catch (\Throwable $th) {
            return redirect()->route('userAskQuestion.index')->with('errors', 'internal server error');
        }
    }

    public function delete(Request $request){
        try {
            $id = $request->id;
            $askquestion = AskYourQuestion::find($id);
         
            $askquestion->delete();

            return response()->json([
                'success' => 1,
                'message' => "AskQuestion deleted Successfully..",
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }
    }
}
