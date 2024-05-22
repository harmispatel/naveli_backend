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
                   <a href=' . route("festival.edit", ["id" => encrypt($event->id), 'locale' => 'en']) . ' class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                   <a onclick="deleteUsers(\'' . $event->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
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

    public function edit($id, $def_locale){
        try {
           $id = decrypt($id);
        
           $festival = Festival::where('id',$id)->first();

           return view('admin.festival.edit',compact(['festival', 'def_locale']));
        } catch (\Throwable $th) {
            return redirect()->route('festival.index')->with('error','Internal Server Error');
        }

    }

    public function update(Request $request){

        try {            
            if(isset($request->language_code) && !empty($request->language_code) && isset($request->id)){
                $input = [
                    'festival_name_'.$request->language_code => $request->festival_name,
                    'date' => $request->date,
                ];
                Festival::find(decrypt($request->id))->update($input);
                return redirect()->back()->with('Message','Festival has been Updated.');
            }else{
                return redirect()->back()->with('error', 'Oops, Something went wrong!');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }

    public function destroy(Request $request){
         try {

            $id = $request->id;
             $festival = Festival::find($id);

             $festival->delete();

             return response()->json([
                'success' => 1,
                'message' => "Festival deleted Successfully..",
            ]);
         } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
         }
    }

}
