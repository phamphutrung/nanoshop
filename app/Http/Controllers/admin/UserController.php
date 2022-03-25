<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    function index(request $request)
    {
        if ($request->user()->cannot('view', User::class)) {
            return redirect()->back()->with('notification', "Bạn không được phép truy cập");
        } else {
            $users = User::latest()->paginate(15);
            $roles = role::all();
            return view('admin.user.index', compact('users', 'roles'));
        }
    }

    function search(request $request)
    {
        $str = $request->str;
        $users = User::where(function ($q) use ($str) {
            $q->where('name', 'like', "%$str%")->orWhere('email', 'like', "%$str%")->orWhere('phone', 'like', "%$str%");
        })->get();
        $view = view('admin.user.main_data', compact('users'))->render();
        return response()->json(['view' => $view]);
    }

    function add(request $request)
    {
        if ($request->user()->cannot('create', User::class)) {
            return response()->json(['code' => -1, 'msg' => 'Bạn không có quyền thêm thành viên']);
        } else {
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
    }

    function edit(request $request)
    {
        $user = User::find($request->id);
        $roles = role::all();
        $roleOfusers = $user->roles;
        $htmlSelectOptionRoles = '';
        foreach ($roles as $role) {
            if ($roleOfusers->contains('id', $role->id)) {
                $htmlSelectOptionRoles .= '<option selected value="' . $role->id . '">' . $role->name . '</option>';
            } else {
                $htmlSelectOptionRoles .= '<option value="' . $role->id . '">' . $role->name . '</option>';
            }
        }
        return response()->json(['user' => $user, 'htmlSelectOptionRoles' => $htmlSelectOptionRoles]);
    }

    function update(request $request)
    {
        if ($request->user()->cannot('update', User::class)) {
            return response()->json(['code' => -1, 'msg' => 'Bạn không có quyền sửa thành viên']);
        } else {
            $id = $request->id;
            $validator = Validator::make($request->all(), [
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
                if ($request->password) {
                    $data_update['password'] = Hash::make($request->password);
                }
                $user = User::find($id);
                $user->update($data_update);
                $user->roles()->sync($request->roles); // bất cứ id nào k có trong mảng roleIds sẽ được xóa ra khỏi bảng trung gian
                $users = User::latest()->paginate(15);
                $view = view('admin.user.main_data', compact('users'))->render();
                return response()->json(['view' => $view, 'msg' => 'Đã cập nhật thành viên']);
            }
        }
    }

    function action(request $request, User $user)
    {

        if ($request->action == "delete single") {
            if ($request->user()->cannot('delete', $user)) {
                return response()->json(['code' => -1, 'msg' => 'Bạn không có quyền xóa thành viên']);
            } else {
                if ($request->id == Auth::user()->id) {
                    return response()->json(['code' => -0, 'msg' => "Không được phép tự xóa"]);
                } else {
                    User::destroy($request->id);
                    DB::table('role_user')->where('user_id', $request->id)->delete();
                }
            }
        }

        if ($request->action == "delete multiple") {
            if ($request->user()->cannot('delete', $user)) {
                return response()->json(['code' => -1, 'msg' => 'Bạn không có quyền xóa thành viên']);
            } else {
                $listId = $request->listId;
                unset($listId[array_search(Auth::user()->id, $listId)]);
                User::destroy($listId);
                foreach ($listId as $id) {
                    DB::table('role_user')->where('user_id', $id)->delete();
                }
            }
        }
        $users = User::latest()->paginate(15);
        $view = view('admin.user.main_data', compact('users'))->render();
        return response()->json(['view' => $view, 'msg' => "Đã xóa thành viên"]);
    }
}
