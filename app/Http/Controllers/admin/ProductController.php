<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use App\Models\product_image;
use Illuminate\Http\Request;
use App\Components\Recursive;

class ProductController extends Controller
{
    function __construct() {
        $this->middleware(function($request, $next){
            session(['module_active'=>'product']);
            return $next($request);
        });
    }
    public function index() {   
        // $products = product::all();
        // $categories = category::all();
    //   $name_product = Category::first()->products->first()->name;
    //   $name_category = product::first()->category->name;
    //   dd($name_category);
       
        return view('admin.product.index');
    }

    public function add() {
        $data = category::all();
        $Recursive = new Recursive($data);
        $htmlSelectOptionCategory = $Recursive->categoryRecursive($id='0', $tr='', '');
        return view('admin.product.add', compact('htmlSelectOptionCategory'));
    }

    // public function insert(request $request) {
    //     // $this->validate($request, [
	// 	// 	'name' => 'required'
    //     //     ]
	// 	// );
    //     if ($request->hasFile('images')) {
    //         $allowedFileExtensions = ['png', 'jpg'];
    //         $exp_flag = true;
    //         $files = $request->file('images');
    //         foreach ($files as $file) {
    //             $extension = $file->getClientOriginalExtension();
    //             $check = in_array($extension, $allowedFileExtensions);
    //             if(!$check) {
    //                 $exp_flag = false;
    //                 break;
    //             }
    //         }

    //     }
    //     if ($exp_flag) {
    //         $product = product::create($request->all());
    //         foreach ($request->images as $image) {
    //             $imageName = $image->getClientOriginalName().time().'.'.$image->getClientOriginalExtension();
    //             $pathImage = $image->move('upload/product/', $imageName);
    //             product_image::create([
    //                 'product_id' => $product->id,
    //                 'file_path' => $pathImage   
    //             ]);
    //         }
    //         return redirect()->route('admin-product')->with('status', 'Thêm sản phẩm thành công');
    //     } else {
    //         dd('chưa chuẩn');
    //     }
    // }
}
