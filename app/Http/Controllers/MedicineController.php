<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MedicineController extends Controller
{

    public function __contsruct()
    {
        $this->middleware('permission:medicine.index|medicine.create|medicine.edit|medicine.destroy', ['only' => ['index', 'show']]);
        $this->middleware('permission:medicine.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:medicine.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:medicine.destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $medicine = Medicine::all();

                return DataTables::of($medicine)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($medicine) {
                        return '<div class="btn-group">
                  <a href=' . route("medicine.edit", ["id" => encrypt($medicine->id)]) . ' class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                  <a href=' . route("medicine.destroy", ["id" => $medicine->id]) . ' class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                  </div>';
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            }
            return view('admin.medicine.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Internal server error');
        }

    }

    public function create()
    {
        return view('admin.medicine.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:medicines',
        ]);

        try {
            $input = $request->except('_token');
            $medicine = Medicine::create($input);

            return redirect()->route('medicine.index')->with('message', 'Medicine saved Successfully');
        } catch (\Throwable $th) {

            return redirect()->route('medicine.index')->with('error', 'Internal Server error!');
        }

    }

    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $medicine = Medicine::find($id);

            return view('admin.medicine.edit', compact('medicine'));
        } catch (\Throwable $th) {
            return redirect()->route('medicine.index')->with('error', 'Internal server error');
        }

    }

    public function update(Request $request)
    {
        $id = decrypt($request->id);
 
        $request->validate([
            'name' => 'required|unique:medicines,name,'.$id,
        ]);

        try {
            $medicine = Medicine::find($id);
            $medicine->name = $request->name;
            $medicine->save();

            return redirect()->route('medicine.index')->with('message', 'Medicine Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('medicine.index')->with('error', 'Internal server error');
        }

    }

    public function destroy($id)
    {
        try {
            $medicine = Medicine::find($id);
            $medicine->delete();

            return redirect()->route('medicine.index')->with('message', 'Medicine Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('medicine.index')->with('error', 'Internal server error');
        }

    }
}
