<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'setting']);
            return $next($request);
        });
    }

    public function index()
    {
        $settings = setting::latest()->paginate(15);
        return view('admin.setting.index', compact('settings'));
    }

    public function add(request $request)
    {
        $validator =  validator::make($request->all(), [
            'config_key' => 'required|max:225|unique:settings',
            'config_value' => 'required|max:1025',
        ], [
            'required' => 'Không được để trống',
            'unique' => 'Đã tồn tại',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 0,
                'error' => $validator->errors()->toArray(),
            ]);
        } else {
            setting::create($request->all());
            $settings = setting::latest()->paginate(15);
            $view = view('admin.setting.main_data', compact('settings'))->render();
            return response()->json(['view' => $view, 'msg' => 'Đã thêm cài đặt']);
        }
    }

    public function edit(request $request)
    {
        if ($request->ajax()) {
            $setting = setting::find($request->id);
            return response()->json(['setting' => $setting]);
        }
    }

    public function update(request $request)
    {
        $id = $request->id;
        $validator =  validator::make($request->all(), [
            'config_key' => "required|unique:settings,config_key,$id,id",
            'config_value' => 'required|max:1025',
        ], [
            'required' => 'Không được để trống',
            'unique' => 'Đã tồn tại',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 0,
                'error' => $validator->errors()->toArray(),
            ]);
        } else {
            setting::find($id)->update([
                'config_key' => $request->config_key,
                'config_value' => $request->config_value,
            ]);
            $settings = setting::latest()->paginate(15);
            $view = view('admin.setting.main_data', compact('settings'))->render();
            return response()->json(['view' => $view, 'msg' => "Đã cập nhật thay đổi"]);
        }
    }
}
