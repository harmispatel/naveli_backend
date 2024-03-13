<?php

namespace App\Http\Controllers;

use App\Models\Age;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AgeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:age.index|age.create|age.edit|age.destroy', ['only' => ['index', 'store']]);
        $this->middleware('permission:age.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:age.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:age.destroy', ['only' => ['delete']]);
    }

    public function index()
    {
        try {
            return view('admin.age.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', 'internal server error');
        }
    }

    public function load(Request $request){
        if ($request->ajax()) {
            $columns = array(
                0 => 'id',
            );
            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
            $search = $request->input('search.value');

            $ages = Age::query()
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('id', 'LIKE', "%{$search}%")
                            ->orWhere('min_age', 'LIKE', "%{$search}%")
                            ->orWhere('max_age', 'LIKE', "%{$search}%");
                    });
                })
                ->orderBy($order, $dir)
                ->offset($start)
                ->limit($limit)
                ->get();

            $totalData = Age::query()->count();
            $totalFiltered = $search ? Age::query()->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('min_age', 'LIKE', "%{$search}%")
                    ->orWhere('max_age', 'LIKE', "%{$search}%");
            })->count() : $totalData;

            $datas = $ages->map(function ($age) {
                return [
                    'id' => $age->id,
                    'min_age' => $age->min_age,
                    'max_age' => $age->max_age,
                    'actions' => view('admin.age.actions', ['age' => $age])->render(),
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

    public function create()
    {
        return view('admin.age.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'min_age' => 'required',
            'max_age' => 'required',
        ]);

        try {
            $input = $request->except('_token');

            $age = Age::create($input);

            return redirect()->route('age.index')->with('message', 'New Age Saved Successfully!');
        } catch (\Throwable $th) {
            return redirect()->route('age.index')->with('error', "internal server error");
        }
    }

    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $ageEdit = Age::find($id);
            return view('admin.age.edit', compact('ageEdit'));
        } catch (\Throwable $th) {
            return redirect()->route('age.index')->with('error', "internal server error");
        }
    }

    public function update(Request $request)
    {

        $request->validate(
            [
                'min_age' => 'required',
                'max_age' => 'required',
            ]
        );

        try {
            $id = decrypt($request->id);
            $Ages = Age::find($id);
            $Ages->min_age = $request->min_age;
            $Ages->max_age = $request->max_age;
            $Ages->update();

            return redirect()->route('age.index')->with('message', 'Age Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('age.index')->with('error', 'Internal Server Error!');
        }
    }

    public function delete($id)
    {
        try {
            $ageDelete = Age::find(decrypt($id));
            $ageDelete->delete();

            return redirect()->route('age.index')->with('message', 'Age Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('age.index')->with('error', 'Internal Server Error!');
        }
    }
}
