<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'roles' => 'required',
            'name' => 'required'
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

    function edit(request $request) {
        $user = User::find($request->id);
        $roles = role::all();
        $roleOfusers = $user->roles;
        $htmlSelectOptionRoles = '';
        foreach ($roles as $role) {
            if( $roleOfusers->contains('id', $role->id)) {
                $htmlSelectOptionRoles .= '<option selected value="' .$role->id .'">'. $role->name .'</option>';
            } else {
                $htmlSelectOptionRoles .= '<option value="' .$role->id .'">'. $role->name .'</option>';
            }
        }
        return response()->json(['user' => $user, 'htmlSelectOptionRoles' => $htmlSelectOptionRoles]);
    }

    function update(request $request) {
        $id = $request->id;
        $validator = Validator::make($request->all(),[
            'email' => "required|email|unique:users,email,$id,id",
            'roles' => 'required',
            'name' => 'required'
        ], [
            'required' => 'Không được để trống',
            'unique' => 'Email đã tồn tại',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['code' => 0, 'error' => $error]);
        } else {
            $data_update = [
                'name' => $request->name,
                'email' => $request->email,
            ];
            if($request->password) {
                $data_update['password'] = Hash::make($request->password);
            }
            $user = User::find($id);
            $user->update($data_update);
            if ($request->roles) {
                foreach ($request->roles as $roleId) {
                    $roleIds[] = $roleId;
                }
                $user->roles()->sync($roleIds); // bất cứ id nào k có trong mảng roleIds sẽ được xóa ra khỏi bảng trung gian
            }
            $users = User::latest()->paginate(15);
            $view = view('admin.user.main_data', compact('users'))->render();
            return response()->json(['view' => $view, 'msg' => 'Đã cập nhật thành viên']);
        }
    }

    function action(request $request) {
        if($request->action == "delete single") {
            User::destroy($request->id);
            DB::table('role_user')->where('user_id', $request->id)->delete();
        } 

        if($request->action == "delete multiple") {
            User::destroy($request->listId);
            foreach($request->listId as $id) {
                DB::table('role_user')->where('user_id', $id)->delete();
            }
        }

        
        $users = User::latest()->paginate(15);
        $view = view('admin.user.main_data', compact('users'))->render();
        return response()->json(['view' => $view, 'msg' => "Đã xóa thành viên"]);
    }
}
