<?php

namespace App\Http\Controllers;
use App\Models\AllAboutPeriodPost;
use App\Models\AllAboutPeriodCategory;
use App\Models\AllAboutPeriodPostMedia;
use App\Traits\ImageTrait;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AllAboutPeriodPostController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('permission:aap.posts.index|aap.posts.create|aap.posts.edit|aap.posts.destroy', ['only' => ['index', 'show']]);
        $this->middleware('permission:aap.posts.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:aap.posts.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:aap.posts.destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request){
        try {
            $allAboutPeriodPosts = AllAboutPeriodPost::all();

            if($request->ajax()){
                return DataTables::of($allAboutPeriodPosts)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    return isset($row->category_name_en) ? $row->category_name_en : '';
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
                            <a href=' . route("aap.posts.edit", ["id" => encrypt($row->id),'locale' => 'en']) . ' class="btn btn-sm custom-btn me-1"> <i class="bi bi-pencil" aria-hidden="true"></i></a>
                            <a onclick="deleteUsers(\'' . $row->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
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
            // $getCategories = AllAboutPeriodCategory::all();
            return view('admin.all_about_periods.posts-create');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }

    public function store(Request $request)
    {

        $customMessages = [
            'category_name_en.required' => 'The category name field is required.',
            'category_name_en.unique' => 'The category name has already been taken.',
            'icon.required' => 'The icon field is required.',
            'icon.image' => 'The icon must be an image.',
            'icon.max' => 'The icon may not be greater than :max kilobytes.',
            'media_links.0.required' => 'The Media Link is required when the file type is "link".',
            'media_files.0.required' => 'The Media File is required when the file type is "image".',
            'media_files.0.image' => 'The Media File must be an image.'
        ];

       $validator = Validator::make($request->all(), [
            'category_name_en' => 'required|unique:all_about_period_posts',
            'icon' => 'required|image|max:2048',
            'media_links.0' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->file_types[0] === 'link';
                })
            ],
            'media_files.0' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->file_types[0] === 'image';
                }),
                'image'
            ],
            'file_types' => ['required', 'array', 'min:1', 'first_not_null'],
            'descriptions' => ['required', 'array', 'min:1', 'first_not_null'],
        ],$customMessages);


        if ($validator->fails()) {
            $failedRules = $validator->failed();

            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        try {

            $input = $request->only('category_name_en');
            // Save icon
            $icon = $request->icon;
            $icon_url = $this->addSingleImage('all_about_periods/category_icons', $icon, $old_image = '');
            $input['category_icon'] = $icon_url;
            $newPost = AllAboutPeriodPost::create($input);

            // Save media and descriptions
            foreach ($request->file_types as $key => $fileType) {

                // Check if both media_links or media_files and descriptions are empty at the same index
                if (($fileType === 'link' && isset($request->media_links[$key])) ||
                ($fileType === 'image' && ($request->hasFile("media_files.$key") || isset($request->media_files[$key]))) &&
                (isset($request->descriptions[$key]) && $request->descriptions[$key] != null)) {

                    $media = null;

                    if ($fileType === 'link') {
                        $media = isset($request->media_links[$key]) ? $request->media_links[$key] : '';
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
                    $mediaModel->description_en = $request->descriptions[$key];
                    $mediaModel->save();
                }

            }


            return redirect()->route('aap.posts.index')->with('message','All About Periods Post Created Successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('aap.posts.index')->with('error','Something Went Wrong!');
        }
    }

    public function edit($id,$def_locale){
        try {
            $id = decrypt($id);
            $findedPost = AllAboutPeriodPost::with('media')->find($id);

            return view('admin.all_about_periods.posts-edit',compact('findedPost','def_locale'));
        } catch (\Throwable $th) {
            return redirect()->route('aap.category.index')->with('error', 'Internal Server Error!');
        }
    }

    public function update(Request $request){

        if(!$request->language_code && empty($request->language_code) && !$request->id){
            return redirect()->back()->with('error','Required Parameters not found!');
        }

        $id = decrypt($request->id);

        $customMessages = [
            'category_name.required' => 'The category name field is required.',
            'category_name.unique' => 'The category name has already been taken.',
            'icon.required' => 'The icon field is required.',
            'icon.image' => 'The icon must be an image.',
            'icon.max' => 'The icon may not be greater than :max kilobytes.',
            'media_links.0.required' => 'The Media Link is required when the file type is "link".',
            'media_files.0.required' => 'The Media File is required when the file type is "image".',
            'media_files.*.image' => 'The Media File must be an image.'
        ];
        $fieldName = 'category_name_' . $request->language_code;
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:all_about_period_posts,' . $fieldName . ','.$id,
            'icon' => 'image|max:2048',
            'media_files.*' => 'image',
            'file_types' => ['required', 'array', 'min:1','first_not_null'],
            'descriptions' => ['required', 'array', 'min:1','first_not_null'],
        ],$customMessages);


        if ($validator->fails()) {
            $failedRules = $validator->failed();
            // dd($failedRules);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

       try {

         // Find the record to update
         $post = AllAboutPeriodPost::with('media')->find($id);

         // Update the category name if it's provided
         if ($request->has('category_name')) {
            $post['category_name_' . $request->language_code] = $request->category_name;
         }

         // Update the icon if it's provided
         if ($request->hasFile('icon')) {
             // Delete the old icon if it exists
             if ($post->category_icon) {
                 $oldIconPath = public_path('images/uploads/all_about_periods/category_icons/' . $post->category_icon);
                 if (file_exists($oldIconPath)) {
                     unlink($oldIconPath);
                 }
             }
             // Handle file upload and update the icon
             $icon = $request->file('icon');
             $icon_url = $this->addSingleImage('all_about_periods/category_icons', $icon, $old_image = '');
             $post->category_icon = $icon_url;
         }


        if ($request->has('media_links') || $request->hasFile('media_files')) {
            $post->media()->delete();
        
            foreach ($request->file_types as $key => $fileType) {
                // Check if both media_links or media_files and descriptions are not null or empty at the same index
                if (($fileType === 'link' && isset($request->media_links[$key])) ||
                    ($fileType === 'image' && $request->hasFile('media_files') && isset($request->media_files[$key]) || isset($post->media[$key]->media)) ||
                    isset($request->descriptions[$key]) && ($request->descriptions[$key] != null)) {
        
                    $media = new AllAboutPeriodPostMedia();
                    $media->media_type = $fileType;
        
                    if ($fileType === 'link') {
                        $media->media = $request->media_links[$key] ?? '';
                    } else {
                        // Handle file upload for media files only if files are provided
                        if ($request->hasFile('media_files') && $request->file('media_files')[$key]->isValid()) {
                            $mediaFile = $request->file('media_files')[$key];
                            $mediaFileName = $this->addSingleImage('all_about_periods/posts_media/', $mediaFile, $old_image = '');
                            $media->media = $mediaFileName;
                        } else {
                            // If media_files are not provided or invalid, keep the existing media file
                            $media->media = $post->media[$key]->media ?? '';
                        }
                    }
                    
                    // Assign description based on $def_locale value
                    if ($request->language_code === 'hi') {

                        $media->description_hi = $request->descriptions[$key] ?? '';
                        $media->description_en = $post->media[$key]->description_en ?? '';
     
                    } else {
                        $media->description_en = $request->descriptions[$key] ?? '';
                        $media->description_hi = $post->media[$key]->description_hi ?? '';
                    }
        
                    // Save media associated with the post
                    $post->media()->save($media);
                }
            }
        }
        
         $post->save();
         return redirect()->route('aap.posts.index')->with('message','All About Periods Post updated successfully');
       } catch (\Throwable $th) {
        return redirect()->route('aap.posts.index')->with('error','something went wrong!');
       }
    }

    public function destroy(Request $request){
        try {
            $id = $request->id;

            $post = AllAboutPeriodPost::with('media')->find($id);

            if (!$post) {
                return redirect()->back()->with('error', 'Post not found');
            }

            foreach ($post->media as $media) {
                File::delete(public_path('images/uploads/all_about_periods/posts_media/' . $media->media));
                $media->delete();
            }

            if ($post->category_icon) {
                File::delete(public_path('images/uploads/all_about_periods/category_icons/' . $post->icon));
            }
            $post->delete();
            return response()->json([
                'success' => 1,
                'message' => "AllAboutPeriod deleted Successfully..",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

    }
}
