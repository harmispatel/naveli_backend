<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('permission:posts.index|posts.create|posts.edit|posts.destroy', ['only' => ['index', 'show']]);
        $this->middleware('permission:posts.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:posts.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:posts.destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        try {
            $posts = Post::get();

            if ($request->ajax()) {

                if (isset($request->parent_title_filter)) {
                    $posts = $posts->where('parent_title', $request->parent_title_filter);
                }

                return DataTables::of($posts)
                    ->addIndexColumn()
                    ->addColumn('posts_category', function ($row) {
                        $post_category_id = $row->parent_title;
                        switch ($post_category_id) {
                            case '1':
                                $message = "Do You Know";
                                break;
                            case '2':
                                $message = "Myth Vs Facts";
                                break;
                            case '3':
                                $message = "All About Periods";
                                break;
                            case '4':
                                $message = "Nutrition";
                                break;
                            default:
                                $message = "No Category";

                        }

                        return $message;
                    })
                    ->addColumn('file_type', function ($row) {
                        return isset($row->file_type) ? $row->file_type : "---";
                    })
                    ->addColumn('actions', function ($posts) {
                        $html_actions = '<div class="btn-group">';
                        $html_actions .= '<a href=' . route("posts.edit", ["id" => encrypt($posts->id) , 'locale' => 'en']) . ' class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil" aria-hidden="true"></i></a>';
                        $html_actions .= '<a onclick="deleteUsers(\'' . $posts->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>';
                        $html_actions .= "</div>";

                        return $html_actions;
                    })
                    ->rawColumns(['actions', 'posts', 'posts_category'])
                    ->make(true);
            }

            return view('admin.post.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', 'internal server error');
        }
    }

    public function create()
    {
        return view('admin.post.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'parent_title' => 'required',
            'description_en' => 'required',
            'file_type' => 'required',
            'posts' => 'required',

        ]);

        try {
            $input = $request->except('_token', 'posts');

            if ($request->hasFile('posts')) {
                $file = $request->posts;
                // $fileExtenstion = $file->getClientOriginalExtension();
                // if (in_array($fileExtenstion, ['mp4', 'avi', 'mov', 'mkv', 'mov', 'flv', 'mpg', 'mpeg', 'webm', 'ogg', 'swf', 'wmv'])) {
                //     $input['file_type'] = 'video';
                // } elseif (in_array($fileExtenstion, ['jpg', 'jpeg', 'png', 'svg', 'webp'])) {
                //     $input['file_type'] = 'image';
                // }
                $file_url = $this->addSingleImage('newsPosts', $file, $old_image = '');
                $input['posts'] = $file_url;
            }else{
                $input['posts'] = $request->posts;
            }

            $posts = Post::create($input);

            return redirect()->route('posts.index')->with('message', 'A New Post Saved Successfully');

        } catch (\Throwable $th) {

            return redirect()->route('posts.index')->with('error', 'Internal Server Error');
        }
    }

    public function edit($id,$def_locale)
    {
        try {
            $id = decrypt($id);
            $postsEdit = Post::find($id);
            return view('admin.post.edit', compact('postsEdit','def_locale'));
        } catch (\Throwable $th) {
            return redirect()->route('posts.index')->with('error', 'Internal Server Error');
        }

    }

    public function update(Request $request)
    {

        $request->validate([
            'parent_title' => 'required',
            'description' => 'required',
            'file_type' => 'required',
            'posts' => 'required',
        ]);

        if(!$request->language_code && empty($request->language_code) && !$request->id){
            return redirect()->back()->with('error','language code not found!');
        }

        try {
            $id = decrypt($request->id);

            $posts = Post::find($id);
            $posts->parent_title = $request->parent_title;
            if($request->language_code == 'hi'){
                $posts->description_hi = $request->description;
            }else{
                $posts->description_en = $request->description;
            }
            $posts->file_type = $request->file_type;

            if ($request->file('posts')) {
                File::delete(public_path('/images/uploads/newsPosts/' . $posts->posts));
                $file = $request->file('posts');
                $file_url = $this->addSingleImage('newsPosts', $file, $old_image = '');
                $posts->posts = $file_url;
            }else{
                $posts->posts = $request->posts;
            }

            $posts->save();

            return redirect()->route('posts.index')->with('message', 'Post Updated Successfully');

        } catch (\Throwable $th) {
            return redirect()->route('posts.index')->with('error', 'Internal Server Error!');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $posts = Post::find($id);
            File::delete(public_path('/images/uploads/newsPosts/' . $posts->posts));
            $posts->delete();

            return response()->json([
                'success' => 1,
                'message' => "Post deleted Successfully..",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

    }
}
