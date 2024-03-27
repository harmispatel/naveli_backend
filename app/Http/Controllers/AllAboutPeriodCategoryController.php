<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{AllAboutPeriodCategory};
use App\Traits\ImageTrait;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class AllAboutPeriodCategoryController extends Controller
{
    use ImageTrait;
    public function index(Request $request){

       try {
        $allAboutPeriodCategories = AllAboutPeriodCategory::all();
        if($request->ajax()){
            return DataTables::of($allAboutPeriodCategories)
                    ->addIndexColumn()
                    ->addColumn('icon', function ($row) {

                        if(isset($row->icon)){
                            $image_path = asset("public/images/uploads/all_about_periods/category_icons/" .$row->icon);
                        }else{
                            $image_path =  asset("public/images/uploads/user_images/no-image.png");
                        }
                       return '<img src='.$image_path.' height="70" width="70">';
                    })
                    ->addColumn('actions', function ($row) {
                        return '<div class="btn-group">
                                <a href=' . route("aap.category.edit", ["id" => encrypt($row->id)]) . ' class="btn btn-sm custom-btn me-1"> <i class="bi bi-pencil" aria-hidden="true"></i></a>
                                <a href=' . route("aap.category.destroy", ["id" => encrypt($row->id)]) . ' class="btn btn-sm btn-danger me-1"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                </div>';
                    })
                    ->rawColumns(['actions', 'icon'])
                    ->make(true);
        }
        return view('admin.all_about_periods.category-list');
       } catch (\Throwable $th) {
         return redirect()->back()->with('error','something went wrong!');
       }
    }

    public function create()
    {
        return view('admin.all_about_periods.category-create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:all_about_period_categories',
            'icon' => 'required|image',
        ]);

        try {

            $input = $request->only('name');

            $icon = $request->icon;
            $icon_url = $this->addSingleImage('all_about_periods/category_icons', $icon, $old_image = '');
            $input['icon'] = $icon_url;
            $newCategory = AllAboutPeriodCategory::create($input);

            return redirect()->route('aap.category.index')->with('message', 'Category Of All About Periods Saved SuccessFully');

        } catch (\Throwable $th) {
            return redirect()->route('aap.category.index')->with('error', 'Internal Server Error!');
        }
    }

    public function edit($id){
        try {
            $id = decrypt($id);
            $findedCategory = AllAboutPeriodCategory::find($id);

            return view('admin.all_about_periods.category-edit',compact('findedCategory'));
        } catch (\Throwable $th) {
            return redirect()->route('aap.category.index')->with('error', 'Internal Server Error!');
        }
    }

    public function update(Request $request){
       
        $id = decrypt($request->id);

        $request->validate([
            'name' => 'required|unique:all_about_period_categories,name,'.$id,
        ]);

        try {
           
            $findedCategory = AllAboutPeriodCategory::find($id);
            $findedCategory->name = $request->name;

            if ($request->file('icon')) {
                File::delete(public_path('/images/uploads/all_about_periods/category_icons' . $findedCategory->icon));
                $icon = $request->icon;
                $icon_url = $this->addSingleImage('all_about_periods/category_icons', $icon, $old_image = '');
                $findedCategory->icon = $icon_url;
            }

            $findedCategory->save();

            return redirect()->route('aap.category.index')->with('message', 'Category Of All About Periods Updated SuccessFully');
        } catch (\Throwable $th) {
            return redirect()->route('aap.category.index')->with('error', 'Internal Server Error!');
        }
    }

    public function destroy($id){
        try {
            $id = decrypt($id);
            $findedCategory = AllAboutPeriodCategory::find($id);

            File::delete(public_path('/images/uploads/all_about_periods/category_icons/' . $findedCategory->icon));
            $findedCategory->delete();

            return redirect()->route('aap.category.index')->with('message', 'Category Of All About Periods Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('aap.category.index')->with('error', 'Internal Server Error!');
        }
    }
}
