<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }

    public function index()
    {
        $sliders = slider::latest()->paginate(15);

        return view('admin.slider.index', compact('sliders'));
    }

    public function add(request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'image|required'
            ],
            [
                'required' => 'Không được để trống :attribute',
                'max' => 'Độ dài khống được vượt quá 150',
                'min' => "Độ dài tối thiểu 2 ký tự",
                'image' => "Tệp không phải là ảnh"
            ],
            [
                'title' => 'tiêu đề',
                'image' => 'hình ảnh',
            ],
        );
        if ($validator->fails()) {
            return response()->json([
                'code' => 0,
                'error' => $validator->errors()->toArray(),
            ]);
        } else {
            $image = $request->file('image');
            $image_name = rand(10, 100000) . $image->getClientOriginalName();
            $image_path = $image->storeAs('slider', $image_name);
            if ($image_path) {
                $slider = slider::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'image_path' => $image_path
                ]);
            }
            $sliders = slider::latest()->paginate(15);
            $view = view('admin.slider.main_data', compact('sliders'))->render();
            return response()->json(['code' => 1, 'message' => "Đã thêm slider", 'view' => $view]);
        }
    }

    public function update(request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'image'
            ],
            [
                'required' => 'Không được để trống :attribute',
                'max' => 'Độ dài khống được vượt quá 150',
                'min' => "Độ dài tối thiểu 2 ký tự",
                'image' => "Tệp không phải là ảnh"
            ],
            [
                'title' => 'tiêu đề',
                'image' => 'hình ảnh',
            ],
        );

        if ($validator->fails()) {
            return response()->json(["code" => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $slider = slider::find($request->id);
            $dataUpdate = [
                'title' => $request->title,
                'description' => $request->description,
            ];
            if ($request->hasFile('image')) {
                if (Storage::exists($slider->image_path)) {
                    Storage::delete($slider->image_path);
                }
                $image = $request->file('image');
                $fileName = rand(10, 100000) . $image->getClientOriginalName();
                $avt_path =  $image->storeAs('slider', $fileName);
                $dataUpdate['image_path'] = $avt_path;
            }
            $slider->update($dataUpdate);
            $sliders = slider::latest()->paginate(15);
            $view = view('admin.slider.main_data', compact('sliders'))->render();

            return response()->json(['code' => 1, 'message' => 'Đã cập nhật thay đổi', 'view' => $view]);
        }
    }

    public function delete(request $request)
    {
        slider::destroy($request->id);
        $sliders = slider::latest()->paginate(15);
        $view = view('admin.slider.main_data', compact('sliders'))->render();
        return response()->json(['code' => 1, 'message' => "Đã xóa slider", 'view' => $view]);
    }

    public function action(request $request)
    {
        if ($request->action == 'delete') {
            $ids = $request->ids;
            slider::destroy($ids);
            $sliders = slider::latest()->paginate(15);
            $view = view('admin.slider.main_data', compact('sliders'))->render();
            return response()->json(['code' => 1, 'message' => 'Đã xóa tất cả lựa chọn', 'view' => $view]);
        } else 
        if ($request->action == 'update active') {
            $id = $request->id;
            $slider = slider::find($id);
            if ($request->status == 'on') {
                $a = $slider->update(['active' => 'on']);
                $msg = 'Đã bật kích hoạt';
                if ($a) {
                    $code = 1;
                }
            } else {
                $a = $slider->update(['active' => 'off']);
                $msg = 'Đã tắt kích hoạt';
                $code = 1;
                if ($a) {
                    $code = 1;
                }
            }
            return response()->json(['code' => $code, 'message' => $msg]);
        } else 
        if ($request->action == "show form edit") {
            $slider = slider::find($request->id);
            return response()->json(['slider' => $slider]);
        }
    }

    public function search(request $request)
    {
        $key = $request->key;
        $sliders = slider::where('title', 'like', '%' . $key . '%')->latest()->paginate(15);
        $view = view('admin.slider.main_data', compact('sliders'))->render();
        return response()->json(['view' => $view, 'msg' => $key]);
    }
}
