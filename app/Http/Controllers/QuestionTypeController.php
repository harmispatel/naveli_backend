<?php

namespace App\Http\Controllers;

use App\Models\QuestionType;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class QuestionTypeController extends Controller
{
    use ImageTrait;

    public function __construct(){
        $this->middleware('permission:questionType.index|questionType.create|questionType.edit|questionType.destroy', ['only' => ['index', 'show']]);
        $this->middleware('permission:questionType.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:questionType.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:questionType.destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $questionType = QuestionType::all();

                return DataTables::of($questionType)
                    ->addIndexColumn()
                    ->addColumn('icon', function ($question) {
                        return '<image src="' . asset('/public/images/uploads/QuestionType/' . $question->icon) . '"
                   class="img-thumbnail" width="70" height="70">';
                    })
                    ->addColumn('actions', function ($question) {
                        $questionType_id = isset($question->id) ? $question->id : '';
                        $action_html = '<div class="btn-group">';
                        $action_html .= '<a href="' . route('questionType.edit', encrypt($question->id)) . '" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';

                        if(!in_array($questionType_id, [1, 2, 3, 4])){
                            $action_html .= '<a onclick="deleteUsers(\'' . $question->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>';
                        }
                        $action_html .= '</div>';

                    return $action_html;
                    })
                    ->rawColumns(['icon', 'actions'])
                    ->make(true);
            }

            return view('admin.questionTypes.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Internal Server Error!');
        }

    }

    public function create()
    {
        return view('admin.questionTypes.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:question_types',
            'icon' => 'required|image',
        ]);

        try {

            $input = $request->only('name');

            $icon = $request->icon;
            $icon_url = $this->addSingleImage('QuestionType', $icon, $old_image = '');
            $input['icon'] = $icon_url;
            $questionType = QuestionType::create($input);

            return redirect()->route('questionType.index')->with('message', 'QuestionType Saved SuccessFully');

        } catch (\Throwable $th) {
            return redirect()->route('questionType.index')->with('error', 'Internal Server Error!');
        }
    }

    public function edit($id)
    {
        try {

            $id = decrypt($id);
            $questionType = QuestionType::find($id);

            return view('admin.questionTypes.edit',compact('questionType'));
        } catch (\Throwable $th) {
            return redirect()->route('questionType.index')->with('error', 'Internal Server Error!');
        }
    }

    public function update(Request $request)
    {
        $id = decrypt($request->id);

        $request->validate([
            'name' => 'required|unique:question_types,name,'.$id,
        ]);

        try {
            $questionType = QuestionType::find($id);
            $questionType->name = $request->name;

            if ($request->file('icon')) {
                File::delete(public_path('/images/uploads/QuestionType/' . $questionType->icon));

                $icon = $request->icon;
                $icon_url = $this->addSingleImage('QuestionType', $icon, $old_image = '');
                $questionType->icon = $icon_url;
            }

            $questionType->save();

            return redirect()->route('questionType.index')->with('message', 'QuestionType Updated SuccessFully');
        } catch (\Throwable $th) {

            return redirect()->route('questionType.index')->with('error', 'Internal Server Error!');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $questionType = QuestionType::find($id);

            File::delete(public_path('/images/uploads/QuestionType/' . $questionType->icon));
            $questionType->delete();

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
