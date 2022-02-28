<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    function __construct() {
        $this->middleware(function($request, $next){
            session(['module_active'=>'slider']);
            return $next($request);
        });
    }

    public function index() {
        $sliders = slider::latest()->get();

        return view('admin.slider.index', compact('sliders'));
    }

    public function add(request $request) {
        
       $validator = Validator::make($request->all(), 
       [
            'title' => 'required|max:255|min:2',
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
       if($validator->fails()) {
            return response()->json([
                'code'=> 0, 
                'error' => $validator->errors()->toArray(),
            ]);
       } else {
           $image = $request->file('image');
           $image_name = rand(10, 100000).$image->getClientOriginalName();
           $image_path = $image->storeAs('slider', $image_name);
          if ($image_path) {
            $slider = slider::create([
                'title' => $request->title,
                'description' => $request->description,
                'image_path' => $image_path
            ]);
          }
           return response()->json(['code' => 1, 'message' => "Đã thêm slider", 'slider' => $slider]);

       }
    }

    public function delete(request $request) {
        slider::destroy($request->id);
        return response()->json(['code' => 1, 'message' => "Đã xóa slider"]);
    }
}
