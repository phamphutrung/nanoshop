<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'account']);
            return $next($request);
        });
    }
    
    function index() {
        return view('admin.account.index');
    }
    function update(request $request) {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'email' => "required|email|unique:users,email,$id,id",
            'phone' => 'required',
            'name' => 'required',
        ], [
            'required' => 'Không được để trống',
            'unique' => 'Email đã tồn tại',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['code' => 0, 'error' => $error]);
        }  else {
            $data_update = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'hometown' => $request->hometown,
            ];
            if ($request->password) {
                $data_update['password'] = Hash::make($request->password);
            }
            if ($request->hasFile('avt')) {
                if (Storage::exists(Auth::user()->avt)) {
                    Storage::delete(Auth::user()->avt);
                }
                $fileName = rand(100, 100000) . $request->avt->getClientOriginalName();
                $avt_path = $request->avt->storeAs('account', $fileName);
                $data_update['avt'] = $avt_path;
            }
            $user = User::find($id);
            $user->update($data_update);
            return response()->json(['msg' => 'đã cập nhật hồ sơ']);
        }
    }
}
