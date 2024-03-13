<?php

namespace App\Http\Controllers;

use App\Models\Ailment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AilmentController extends Controller
{
    public function __contsruct()
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
                   <a href=' . route("ailments.edit", ["id" => encrypt($ailment->id)]) . ' class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                   <a href=' . route("ailments.destroy", ["id" => $ailment->id]) . ' class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
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
            'name' => 'required|unique:ailments',
        ]);

        try {

            $input = $request->except('_token');

            $ailments = Ailment::create($input);

            return redirect()->route('ailments.index')->with('message', 'Ailment saved Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('ailments.index')->with('error', 'Internal Server error!');
        }

    }

    public function edit($id)
    {
        try {
            $id = decrypt($id);

            $ailments = Ailment::find($id);

            return view('admin.ailments.edit', compact('ailments'));
        } catch (\Throwable $th) {
            return redirect()->route('ailments.index')->with('error', 'Internal Server error!');
        }

    }

    public function update(Request $request)
    {
        $id = decrypt($request->id);

        $request->validate([
            'name' => 'required|unique:ailments,name,'.$id,
        ]);

        try {

            $ailments = Ailment::find($id);
            $ailments->name = $request->name;
            $ailments->save();

            return redirect()->route('ailments.index')->with('message', 'Ailment Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('ailments.index')->with('error', 'Internal server error');
        }

    }

    public function destroy($id)
    {
        try {
            $ailments = Ailment::find($id);
            $ailments->delete();

            return redirect()->route('ailments.index')->with('message', 'Ailment Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('ailments.index')->with('error', 'Internal Server error!');
        }

    }
}
