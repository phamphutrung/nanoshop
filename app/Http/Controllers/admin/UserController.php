<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }

    function index()
    {
        $users = User::latest()->paginate(15);
        $roles = role::all();
        return view('admin.user.index', compact('users', 'roles'));
    }

    function add(request $request)
    {
        $validator  = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'roles' => 'required'
        ], [
            'required' => 'Không được để trống',
            'unique' => 'Email đã tồn tại',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['code' => 0, 'error' => $error]);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            foreach ($request->roles as $roleItem) {
                $role_ids[] = $roleItem;
            }
            $user->roles()->attach($role_ids);
            $users = User::latest()->paginate(15);
            $view = view('admin.user.main_data', compact('users'))->render();
            return response()->json(['code' => 1, 'view' => $view, 'msg' => 'Đã thêm thành viên mới']);
        }
    }
}
