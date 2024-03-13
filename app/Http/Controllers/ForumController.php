<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\ForumCategory;
use Yajra\DataTables\Facades\DataTables;

class ForumController extends Controller
{
   public function index(Request $request){

     if($request->ajax()){
        $getForums = Forum::all();

        return DataTables::of($getForums)
        ->addIndexColumn()
        ->addColumn('forums_category', function ($row) {
            $parent_category = $row->forum_category_id;
            $findCategoryData = ForumCategory::where('id',$parent_category)->first();

            if(isset($findCategoryData)){
                return isset($findCategoryData->name) ? $findCategoryData->name : null;
            }else{
               return "--";
            }
           return '';
        })
        ->addColumn('forums_subcategory', function ($row) {
            $child_category = $row->forum_subcategory_id;
            $findCategoryData = ForumCategory::where('id',$child_category)->first();
            if(isset($findCategoryData)){
                return isset($findCategoryData->name) ? $findCategoryData->name : null;
            }else{
                return "<span style='font-size: 14px; color: #333; '>No Sub-Category</span>";
            }
          return '';
        })
        ->addColumn('actions', function ($row) {
            return '<div class="btn-group">
                <a href=' . route("forums.edit", ["id" => encrypt($row->id)]) . ' class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil" aria-hidden="true"></i></a>
                <a href=' . route("forums.destroy", ["id" => $row->id]) . ' class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                </div>';
        })
        ->rawColumns(['actions','forums_category','forums_subcategory'])
        ->make(true);
     }
     return view('admin.forums.index');
   }

   public function create(Request $request){

    $mainCategories = ForumCategory::where('parent_id',null)->get();
     return view('admin.forums.create',compact('mainCategories'));
   }

   public function store(Request $request){
        $request->validate([
            'forums_category' => "required",
            'title' => "required",
        ]);
        try {

            $createNewForum = new Forum();
            $createNewForum->forum_category_id = isset($request->forums_category) ? $request->forums_category : null;
            $createNewForum->forum_subcategory_id = isset($request->forums_subcategory) ? $request->forums_subcategory : null;
            $createNewForum->title = $request->title;
            $createNewForum->description = $request->description;
            $createNewForum->save();

            return redirect()->back()->with('message','Forum Created Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','internal server error !');
        }
   }

   public function getSubCategory(Request $request){
    if($request->ajax()){

        $categoryId = $request->categoryId;
        $subcategories = ForumCategory::where('parent_id', $categoryId)->get();

        return response()->json($subcategories);
    }
   }

   public function edit($id){
    try {
        $id = decrypt($id);
        $forumRecord = Forum::find($id);
        $mainCategories = ForumCategory::where('parent_id',null)->get();
        $childCategories = ForumCategory::where('parent_id',$forumRecord->forum_category_id)->get();

        return view('admin.forums.edit', compact('forumRecord','mainCategories','childCategories'));
    } catch (\Throwable $th) {
        return redirect()->route('healthMix.index')->with('error', 'Internal Server Error!');
    }
   }


    public function update(Request $request){
        // return redirect()->back()->with('error','Update Work In Process...');
        
        $request->validate([
            'forums_category' => "required",
            'title' => "required",
        ]);
        try {
            $id = decrypt($request->id);
            
            if(isset($id)){  

                $forumRecord = Forum::find($id);

                $update = $forumRecord->update([
                    'forum_category_id' => isset($request->forums_category) ? $request->forums_category:'',
                    'forum_subcategory_id' => isset($request->forums_subcategory) ? $request->forums_subcategory: '',
                    'title' => isset($request->title) ?$request->title: '',
                    'description' => isset($request->description) ? $request->description: ''
                ]);
                
                return redirect()->route('forums.index')->with('message', 'Forum Updated Successfully');
            }
            return redirect()->route('forums.edit')->with('error', 'Something want wrong!');
        } catch (\Throwable $th) {
            
            return redirect()->route('forums.index')->with('error', 'Internal Server Error!');
        }
    }
    public function destroy($id){
        try {
            $forumRecord = Forum::find($id);
            $forumRecord->delete();

            return redirect()->route('forums.index')->with('message', 'Forum Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('forums.index')->with('error', 'Internal Server Error!');
        }
    }

}
