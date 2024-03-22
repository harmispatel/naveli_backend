<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class Rolecontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles|roles.create|roles.edit|roles.destroy', ['only' => ['index', 'show']]);
        $this->middleware('permission:roles.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:roles.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:roles.destroy', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $roles = Role::get();
                return DataTables::of($roles)
                    ->addIndexColumn()
                    ->addColumn('actions', function ($row) {
                        $role_id = isset($row->id) ? $row->id : '';
                        $action_html = '<div class="btn-group">';
                        $action_html .= '<a href="' . route('roles.edit', encrypt($row->id)) . '" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';


                        if($role_id != 1 && $role_id != 2 && $role_id != 3 && $role_id != 4){
                            $action_html .= '<a onclick="deleteRole(\'' . $row->id . '\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                        }

                        $action_html .= '</div>';
                        return $action_html;
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            }
            return view('admin.roles.list');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

    public function create()
    {
        $permission = Permission::get();

        return view('admin.roles.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles',
        ]);

        try {

            $role = Role::create(['name' => $request->input('name')]);

            if(isset($request->permission)){
                $permissions = Permission::whereIn('id', $request->permission)->get();
                $role->syncPermissions($permissions);
            }

            return redirect()->route('roles')
                ->with('message', 'Role created successfully');
        } catch (\Throwable $th) {
        return redirect()->route('roles')->with('error', 'Something went wrong');
        }
    }

    public function edit(Request $request, $id)
    {
        try {

            $id = decrypt($id);
            $role = Role::find($id);
            $permission = Permission::get();
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
                ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                ->all();
            return view('admin.roles.edit', compact('role', 'permission', 'rolePermissions'));

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

    public function update(Request $request)
    {
        $id = decrypt($request->id);

        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
        ]);

        try {

            $role = Role::find($id);

            $role->name = $request->input('name');
            $role->save();

            if(isset($request->permission)){

                $permissions = Permission::whereIn('id', $request->permission)->get();
                $role->syncPermissions($permissions);
            }

            return redirect()->route('roles')
                ->with('message', 'Role updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $role = Role::where('id', $id)->delete();

            return response()->json(
                [
                    'success' => 1,
                    'message' => "Role delete Successfully..",
                ]
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => 0,
                    'message' => "Something went wrong",
                ]
            );
        }
    }
}
