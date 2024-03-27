<?php

namespace App\Http\Controllers;
use App\Models\AllAboutPeriodPost;
use App\Models\AllAboutPeriodCategory;
use App\Models\AllAboutPeriodPostMedia;
use App\Traits\ImageTrait;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AllAboutPeriodPostController extends Controller
{
    use ImageTrait;
    public function index(Request $request){
        try {
            $allAboutPeriodPosts = AllAboutPeriodPost::with('category')->get();

            if($request->ajax()){
                return DataTables::of($allAboutPeriodPosts)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                   
                    return isset($row->category_name) ? $row->category_name : '';
                 })
                 ->addColumn('icon', function ($row) {

                    if(isset($row->category_icon)){
                        $image_path = asset("public/images/uploads/all_about_periods/category_icons/" .$row->category_icon);
                    }else{
                        $image_path =  asset("public/images/uploads/user_images/no-image.png");
                    }
                   return '<img src='.$image_path.' height="70" width="70">';
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                            <a href=' . route("aap.posts.edit", ["id" => encrypt($row->id)]) . ' class="btn btn-sm custom-btn me-1"> <i class="bi bi-pencil" aria-hidden="true"></i></a>
                            <a href=' . route("aap.posts.destroy", ["id" => encrypt($row->id)]) . ' class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                            </div>';
                })
                ->rawColumns(['actions', 'media','media_type','category','icon'])
                ->make(true);
            }
            return view('admin.all_about_periods.posts-list');
        } catch (\Throwable $th) {
           return redirect()->route('aap.posts.index')->with('error','Something Went Wrong!');
        }
    }

    public function create(){
        try {
            $getCategories = AllAboutPeriodCategory::all();
            return view('admin.all_about_periods.posts-create',compact('getCategories'));
            return redirect()->back()->with('error','Working in Process comming soon...');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Working in Process comming soon...');
        }
        return redirect()->back()->with('error','Working in Process comming soon...');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:all_about_period_posts', 
            'icon' => 'required|image|max:2048', 
            'media_links' => ['required', 'array', 'min:1', 'first_not_null'],
            'file_types' => ['required', 'array', 'min:1', 'first_not_null'],
            'descriptions' => ['required', 'array', 'min:1', 'first_not_null'],
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        dd($request->all());
       try {
        $input = $request->only('category_name');
        // Save icon
        $icon = $request->icon;
        $icon_url = $this->addSingleImage('all_about_periods/category_icons', $icon, $old_image = '');
        $input['category_icon'] = $icon_url;
        $newPost = AllAboutPeriodPost::create($input);
        
        // Save media and descriptions
        foreach ($request->file_types as $key => $fileType) {
            
            $media = null;
            if ($fileType === 'link') {
                $media = $request->media_links[$key];
            } else {
                if ($request->hasFile("media_files.$key")) {
                    $icon = $request->media_files[$key];
                    $filename =  $this->addSingleImage('all_about_periods/posts_media', $icon, $old_image = ''); 
                    $media = $filename;
                }
            }
    
            // Save media and description to Media table
            $mediaModel = new AllAboutPeriodPostMedia();
            $mediaModel->post_id = $newPost->id; 
            $mediaModel->media = $media;
            $mediaModel->media_type = $fileType;
            $mediaModel->description = $request->descriptions[$key];
            $mediaModel->save();
        }
    
        return redirect()->route('aap.posts.index')->with('message','All About Periods Post Created Successfully.');
       } catch (\Throwable $th) {
        return redirect()->route('aap.posts.index')->with('error','Something Went Wrong!');
       }
    }

    public function edit($id){
        try {
            $id = decrypt($id);
            $findedPost = AllAboutPeriodPost::find($id)->with('media')->first();
            return view('admin.all_about_periods.posts-edit',compact('findedPost'));
        } catch (\Throwable $th) {
            return redirect()->route('aap.category.index')->with('error', 'Internal Server Error!');
        }
    }
    public function update(){
        return redirect()->back()->with('error','Working in Process comming soon...');
    }
    public function destroy(){
        return redirect()->back()->with('error','Working in Process comming soon...');
    }
}
