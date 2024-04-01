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
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }

    public function store(Request $request)
    {
        $customMessages = [
            'category_name.required' => 'The category name field is required.',
            'category_name.unique' => 'The category name has already been taken.',
            'icon.required' => 'The icon field is required.',
            'icon.image' => 'The icon must be an image.',
            'icon.max' => 'The icon may not be greater than :max kilobytes.',
            'media_links.0.required' => 'The Media Link is required when the file type is "link".',
            'media_files.0.required' => 'The Media File is required when the file type is "image".',
            'media_files.0.image' => 'The Media File must be an image.'
        ];

       $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:all_about_period_posts',
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
            $input = $request->only('category_name');
            // Save icon
            $icon = $request->icon;
            $icon_url = $this->addSingleImage('all_about_periods/category_icons', $icon, $old_image = '');
            $input['category_icon'] = $icon_url;
            $newPost = AllAboutPeriodPost::create($input);

            // Save media and descriptions
            foreach ($request->file_types as $key => $fileType) {

                // Check if both media_links or media_files and descriptions are empty at the same index
                if (($fileType === 'link' && empty($request->media_links[$key])) ||
                ($fileType === 'image' && (!$request->hasFile("media_files.$key") || empty($request->media_files[$key]))) ||
                empty($request->descriptions[$key])) {
                continue; // Skip this iteration if any condition is met
                }

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
            $findedPost = AllAboutPeriodPost::with('media')->find($id);

            return view('admin.all_about_periods.posts-edit',compact('findedPost'));
        } catch (\Throwable $th) {
            return redirect()->route('aap.category.index')->with('error', 'Internal Server Error!');
        }
    }

    public function update(Request $request){

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

        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:all_about_period_posts,category_name,'.$id,
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
             $post->category_name = $request->category_name;
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

         // Update media if provided
        //  if ($request->has('media_links') || $request->hasFile('media_files')) {
        //     // Remove existing media associated with the post and delete their files
        //     foreach ($post->media as $media) {

        //         if (!empty($media->media)) {
        //             // Delete the media file if it exists
        //             $mediaFilePath = public_path('images/uploads/all_about_periods/posts_media/' . $media->media);
        //             if (file_exists($mediaFilePath)) {
        //                 unlink($mediaFilePath);
        //             }
        //         }
        //         $media->delete();
        //     }

        //     // Loop through the provided media data
        //     foreach ($request->file_types as $key => $fileType) {
        //         $media = new AllAboutPeriodPostMedia();
        //         $media->media_type = $fileType;

        //         if ($fileType == 'link') {
        //             $media->media = isset($request->media_links[$key]) ? $request->media_links[$key] : '';
        //         } else {
        //             // Handle file upload for media files only if files are provided
        //             if ($request->hasFile('media_files') && isset($request->media_files[$key])) {
        //                 $mediaFile = $request->media_files[$key];
        //                 $mediaFileName = $this->addSingleImage('all_about_periods/posts_media/', $mediaFile, $old_image = '');
        //                 $media->media = $mediaFileName;
        //             } else {
        //                 // If media_files are not provided, keep the existing media file
        //                 $media->media = $post->media[$key]->media;
        //             }
        //         }
        //         $media->description = $request->descriptions[$key];
        //         // Save media associated with the post
        //         $post->media()->save($media);
        //     }
        // }

        if ($request->has('media_links') || $request->hasFile('media_files')) {
            // Remove existing media associated with the post from the database
            foreach ($post->media as $media) {
                $media->delete();
            }

            // Loop through the provided media data
            foreach ($request->file_types as $key => $fileType) {
                switch ($fileType) {
                    case 'link':
                        // Check if description and media_link are not null
                        if ($request->descriptions[$key] !== null && $request->media_links[$key] !== null) {
                            $media = new AllAboutPeriodPostMedia();
                            $media->media_type = $fileType;
                            $media->media = $request->media_links[$key];
                            $media->description = $request->descriptions[$key];
                            // Save media associated with the post
                            $post->media()->save($media);
                        }
                        break;

                    case 'image':
                        // Check if description and media_files are not null and media_files has key $key
                        if ($request->descriptions[$key] !== null && $request->hasFile('media_files') && isset($request->media_files[$key])) {
                            $media = new AllAboutPeriodPostMedia();
                            $media->media_type = $fileType;
                            $mediaFile = $request->media_files[$key];
                            $mediaFileName = $this->addSingleImage('all_about_periods/posts_media/', $mediaFile, $old_image = '');
                            $media->media = $mediaFileName;
                            $media->description = $request->descriptions[$key];
                            // Save media associated with the post
                            $post->media()->save($media);
                        }
                        break;

                    default:
                        // Handle invalid file types or other conditions
                        break;
                }
            }
        }


         $post->save();
         return redirect()->route('aap.posts.index')->with('message','All About Periods Post updated successfully');
       } catch (\Throwable $th) {
        return redirect()->route('aap.posts.index')->with('error','something went wrong!');
       }
    }

    public function destroy($id){
        try {
            $id = decrypt($id);

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
            return redirect()->route('aap.posts.index')->with('message','All About Periods Post Deleted successfully');
        } catch (\Throwable $th) {

            return redirect()->route('aap.posts.index')->with('error','something went wrong!');
        }

    }
}
