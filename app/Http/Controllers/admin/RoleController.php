<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\permission;
use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);
            return $next($request);
        });
    }
    function index()
    {
        $roles = role::latest()->paginate(15);
        $permissionParents = permission::where('parent_id', 0)->get();
        return view('admin.role.index', compact('roles', 'permissionParents'));
    }

    function add(request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:225|unique:roles',
        ], [
            'required' => 'Không được để trống',
            'max' => 'Độ dài vượt quá 225 ký tự',
            'unique' => 'Đã tồn tại vai trò này'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(['code' => 0, 'errors' => $errors]);
        } else {
            $role = role::create($request->all());
            $role->permissions()->attach($request->permission_ids);
            $roles = role::latest()->paginate(15);
            $view = view('admin.role.main_data', compact('roles'))->render();
            return response()->json(['msg' => 'Đã thêm vai trò', 'view' => $view]);
        }
    }

    function update(request $request)
    {
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'name' => "max:225|required|unique:roles,name,$id,id",
        ], [
            'required' => 'Không được để trống',
            'unique' => 'đã tồn tại',
            'max' => "Vượt quá ký tự quy đinh (225)"
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(['code' => 0, 'errors' => $errors]);
        } else {
            $role = role::find($id);
            $role->update($request->all());
            $permission_ids = [];
            $role->permissions()->sync($request->permission_ids);
            $roles = role::latest()->paginate(15);
            $view = view('admin.role.main_data', compact('roles'))->render();
            return response()->json(['msg' => 'Đã cập nhật vai trò', 'view' => $view]);
        }
    }

    function edit(request $request)
    {
        $id = $request->id;
        $role = role::find($id);
        $permissionParents = permission::where('parent_id', 0)->get();
        $permissionOfRoles = $role->permissions;
        $viewPermission_data = view('admin.role.permission_data', compact('permissionParents', 'permissionOfRoles'))->render();
        return response()->json(['role' => $role, 'viewPermission_data' => $viewPermission_data]);
    }

    function delete(request $request) {
        $role = role::find($request->id);
        $role->permissions()->detach();
        $role->delete();
        $roles = role::latest()->paginate(15);
        $view = view('admin.role.main_data', compact('roles'))->render();
        return response()->json(['msg' => 'Đã xóa vai trò', 'view' => $view]);
    }
}
