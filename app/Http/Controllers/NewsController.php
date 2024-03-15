<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('permission:woman-in-news.index|woman-in-news.create|woman-in-news.edit|woman-in-news.destroy', ['only' => ['index', 'show']]);
        $this->middleware('permission:woman-in-news.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:woman-in-news.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:woman-in-news.destroy', ['only' => ['destroy']]);
    }

    // Display a listing of the resource.
    public function index()
    {
        return view('admin.woman_in_news.index');
    }


    // Load all woman news with helping AJAX Datatable
    public function load(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
                0 => 'id',
                1 => 'title'
            );
            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $search = $request->input('search.value');

            $woman_in_newses = News::query()
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('id', 'LIKE', "%{$search}%")
                            ->orWhere('title', 'LIKE', "%{$search}%");
                    });
                })
                ->orderBy($order, $dir)
                ->offset($start)
                ->limit($limit)
                ->get();

            $totalData = News::query()->count();
            $totalFiltered = $search ? News::query()->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%");
            })->count() : $totalData;

            $datas = $woman_in_newses->map(function ($woman_in_news) {
                return [
                    'id' => $woman_in_news->id,
                    'title' => $woman_in_news->title,
                    'description' => $woman_in_news->description,
                    'post' => view('admin.woman_in_news.post', ['woman_in_news' => $woman_in_news])->render(),
                    'actions' => view('admin.woman_in_news.actions', ['woman_in_news' => $woman_in_news])->render(),
                ];
            })->toArray();

            return response()->json([
                "draw"            => intval($request->request->get('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),
                "data"            => $datas
            ]);
        }
    }


    // Show the form for creating a new resource.
    public function create()
    {
        return view('admin.woman_in_news.create');
    }


    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
        ];

        if ($request->media_type == 'link') {
            $rules += [
                'link' => 'required',
            ];
        } else {
            $rules += [
                'image' => 'required|mimes:jpeg,png,jpg,svg|max:4096',
            ];
        }

        $request->validate($rules);

        try {

            $input = $request->except('_token', 'image', 'link', 'media_type');
            $input['file_type'] = $request->media_type;
            if ($request->media_type == 'link') {
                $input['posts'] = $request->link;
            } else {
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $uploaded_file = $this->addSingleImage('newsPosts', $file, $old_image = '');
                    $input['posts'] = $uploaded_file;
                }
            }
            News::create($input);
            return redirect()->route('woman-in-news.index')->with('message', 'Woman News has been Inserted.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }


    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try {
            $woman_in_news = News::find(decrypt($id));
            return view('admin.woman_in_news.edit', compact('woman_in_news'));
        } catch (\Throwable $th) {
            return redirect()->route('news.index')->with('error', 'Oops, Something went wrong!');
        }
    }


    // Update the specified resource in storage.
    public function update(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
        ];

        if ($request->media_type == 'link') {
            $rules += [
                'link' => 'required',
            ];
        } else {
            $rules += [
                'image' => 'nullable|mimes:jpeg,png,jpg,svg|max:4096',
            ];
        }

        $request->validate($rules);

        try {
            $woman_in_news = News::find(decrypt($request->id));
            $input = $request->except('_token', 'id', 'image', 'link', 'media_type');
            $input['file_type'] = $request->media_type;

            if ($request->media_type == 'link') {
                $input['posts'] = $request->link;
            } else {
                if ($request->hasFile('image')) {
                    $old_image = (isset($woman_in_news->posts) && !empty($woman_in_news->posts)) ? $woman_in_news->posts : null;
                    $file = $request->file('image');
                    $uploaded_file = $this->addSingleImage('newsPosts', $file, $old_image);
                    $input['posts'] = $uploaded_file;
                }
            }
            $woman_in_news->update($input);
            return redirect()->route('woman-in-news.index')->with('message', 'Woman News has been Updated.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }


    // Remove the specified resource from storage.
    public function destroy($id)
    {
        try {
            $woman_in_news = News::find(decrypt($id));
            $post = (isset($woman_in_news->posts)) ? $woman_in_news->posts : '';
            if (isset($post) && !empty($post) && file_exists('public/images/uploads/newsPosts/' . $post)) {
                unlink('public/images/uploads/newsPosts/' . $post);
            }
            $woman_in_news->delete();
            return redirect()->route('woman-in-news.index')->with('message', 'Woman news has been Deleted.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, something went wrong!');
        }
    }
}
