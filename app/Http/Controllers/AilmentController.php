<?php

namespace App\Http\Controllers;

use App\Models\Ailment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AilmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ailments.index|ailments.create|ailments.edit|ailments.destroy', ['only' => ['index', 'show']]);
        $this->middleware('permission:ailments.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:ailments.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ailments.destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        try {
            if ($request->ajax()) {
                $ailments = Ailment::all();

                return DataTables::of($ailments)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($ailment) {
                        return '<div class="btn-group">
                   <a href=' . route("ailments.edit", ["id" => encrypt($ailment->id) , 'locale' => 'en']) . ' class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                   <a onclick="deleteUsers(\'' . $ailment->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                   </div>';
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            }
            return view('admin.ailments.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

    public function create()
    {
        return view('admin.ailments.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name_en' => 'required|unique:ailments',
        ]);

        try {

            $input = $request->except('_token');
            $ailments = Ailment::create($input);

            return redirect()->route('ailments.index')->with('message', 'Ailment saved Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('ailments.index')->with('error', 'Internal Server error!');
        }

    }

    public function edit($id,$def_locale)
    {
        try {
            $id = decrypt($id);

            $ailments = Ailment::find($id);

            return view('admin.ailments.edit', compact('ailments','def_locale'));
        } catch (\Throwable $th) {
            return redirect()->route('ailments.index')->with('error', 'Internal Server error!');
        }

    }

    public function update(Request $request)
    {
        if(!$request->language_code && empty($request->language_code) && !$request->id){
            return redirect()->back()->with('error','Required Parameter Not Found!');
        }
        
        $id = decrypt($request->id);
        $fieldName = 'name_' . $request->language_code;

        $request->validate([
            $fieldName => 'required|unique:ailments,' . $fieldName . ',' . $id,
        ]);


        try {

            $ailments = Ailment::find($id);
            $ailments->$fieldName = $request->input($fieldName);
            $ailments->save();

            return redirect()->route('ailments.index')->with('message', 'Ailment Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('ailments.index')->with('error', 'Internal server error');
        }

    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $ailments = Ailment::find($id);
            $ailments->delete();

            return response()->json([
                'success' => 1,
                'message' => "Ailment deleted Successfully..",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

    }
}
