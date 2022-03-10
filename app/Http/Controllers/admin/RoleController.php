<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\permission;
use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'role']);
            return $next($request);
        });
    }
    function index() {
        $roles = role::latest()->paginate(15);
        $permissionParents = permission::where('parent_id', 0)->get();
        return view('admin.role.index', compact('roles', 'permissionParents'));
    }

    function add(request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:225|unique:roles',
        ], [
            'required' => 'Không được để trống',
            'max' => 'Độ dài vượt quá 225 ký tự',
            'unique' => 'Đã tồn tại vai trò này'
        ]);
        if($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(['code' => 0, 'errors' => $errors]);
        } else {
            $role = role::create($request->all());
            $role->permissions()->attach($request->permissions);
            return response()->json(['msg' => 'Đã thêm vai trò']);
        }
    }

}
