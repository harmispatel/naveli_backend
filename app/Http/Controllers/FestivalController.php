<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Festival;
use Yajra\DataTables\Facades\DataTables;

class FestivalController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:festival.index|festival.create|festival.edit|festival.destroy', ['only' => ['index', 'show']]);
        $this->middleware('permission:festival.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:festival.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:festival.destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request){
        try {
            if($request->ajax()){

                $festival = Festival::all();

                return DataTables::of($festival)
                ->addIndexColumn()
                ->addColumn('actions', function($event){
                    return '<div class="btn-group">
                   <a href=' . route("festival.edit", ["id" => encrypt($event->id)]) . ' class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                   <a href=' . route("festival.destroy", ["id" => $event->id]) . ' class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                   </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
            }
            return view('admin.festival.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function create(){
        return view('admin.festival.create');
    }

    public function store(Request $request){
        $request->validate([
            'date' => 'required',
            'festival_name' => 'required'
        ]);

        try {
            $input = $request->except('_token');
           $festival = Festival::create($input);

           return redirect()->route('festival.index')->with('message', 'Festival saved Successfully');
        } catch (\Throwable $th) { 
            return redirect()->route('festival.index')->with('error', 'Internal Server Error');
        }
    }

    public function edit($id){
        try {
           $id = decrypt($id);
        
           $festival = Festival::where('id',$id)->first();

           return view('admin.festival.edit',compact('festival'));
        } catch (\Throwable $th) {
            return redirect()->route('festival.index')->with('error','Internal Server Error');
        }

    }

    public function update(Request $request){

        try {
           
            $id = decrypt($request->id);
            $festival = Festival::find($id);
            $festival->date = $request->date;
            $festival->festival_name = $request->festival_name;
            $festival->save();

            return redirect()->route('festival.index')->with('Message','Festival Updated Successfully');

        } catch (\Throwable $th) {
            return redirect()->route('festival.index')->with('error','Internal Server Error');

        }
    }

    public function destroy($id){
         try {
             $festival = Festival::find($id);

             $festival->delete();

             return redirect()->route('festival.index')->with('Message','Festival Deleted Successfully');
         } catch (\Throwable $th) {
            return redirect()->route('festival.index')->with('error','Internal Server Error');
         }
    }

}
