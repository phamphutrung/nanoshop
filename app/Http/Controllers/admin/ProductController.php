<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use App\Models\product_image;
use Illuminate\Http\Request;
use App\Components\Recursive;
use App\Models\tag;
use Illuminate\Support\Facades\Storage;
use App\Components\getHtml;
use App\Models\product_tag;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    function __construct() {
        $this->middleware(function($request, $next){
            session(['module_active'=>'product']);
            return $next($request);
        });
    }
    public function index(request $request) {   
        if($request->status == 'trash') {
            $products = product::latest()->onlyTrashed()->paginate(15);
        } else {
            $products = product::latest()->paginate(15);
        }
        $countActive = product::all()->count();
        $countTrash = product::onlyTrashed()->count();

       
        return view('admin.product.index', compact('products', 'countActive', 'countTrash'));
    }

    public function viewProductDetail(request $request) {
        $product = product::find($request->id);
        $category = $product->category ? $product->category->name : '';
        $image_detail_path = $product->product_images;
        
        return response()->json([
            'name' => $product->name,
            'category' => $category,
            'original_price' => $product->original_price,
            'selling_price' => $product->selling_price,
            'avt_path' => $product->feature_image_path,
            'image_detail_path' => $image_detail_path,
            'description' => $product->description,
            'content' => $product->content,
        ]);
    }

    public function add() {
        $data = category::all();
        $Recursive = new Recursive($data);
        $htmlSelectOptionCategory = $Recursive->categoryRecursive($id='0', $tr='', '');

        $tags = tag::all();
        $getHtml = new GetHtml;
        $htmlSelectOptionTag = $getHtml->getHtmlTags($tags, []);
        
        return view('admin.product.add', compact('htmlSelectOptionCategory', 'htmlSelectOptionTag'));
    }

    public function insert(request $request) {
         $this->validate($request, [
			'name' => 'required',
        ],[
            'required' => 'Không được để trống'
        ]
		);
        $dataProductCreate = [
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'selling_price' => $request->selling_price,
            'trending' => $request->trending?"1":"0",
            'status' => $request->status?"1":"0",
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ];
        if ($request->hasFile('feature_image_path')) {
            $fileName =rand(100, 100000) . $request->feature_image_path->getClientOriginalName();
            $avt_path= $request->feature_image_path->storeAs('product', $fileName);
            $dataProductCreate['feature_image_path'] = $avt_path;
        }
        $product = product::create($dataProductCreate);

        if ($request->hasFile('image_path')) {
            foreach ($request->image_path as $item) {
                $image_name = rand(100, 100000).$item->getClientOriginalName();
                $image_path = $item->storeAs('product', $image_name);
                product_image::create([
                    'product_id' => $product->id,
                    'image_path' => $image_path,
                ]);
            }
        }
        if ($request->tags) { 
            foreach ($request->tags as $tagItem) {
               $tag = tag::firstOrCreate(['name' => $tagItem]);
               $tagId[] = $tag->id;
               //    product_tag::create([
                   //        'product_id' => $product->id,
                   //        'tag_id' => $tag->id,
                   //    ]);
                }
                $product->tags()->attach($tagId);
        }
   
        return redirect()->route('admin-product')->with('status', 'Thêm sản phẩm thành công');
        
      
    }

    public function edit($id) {

        $product = product::find($id);
        $tags_array = [];
        foreach ($product->tags as $tagItem) {
            $tags_array[] = $tagItem->name;
        }
        $tag_data = tag::all();
        $getHtml = new getHtml;
        $htmlSelectOptionTag = $getHtml->getHtmlTags($tag_data, $tags_array);
      
        
        $category_data = Category::all();
        $category_id = $product->category? $product->category->id : null;
        // dd($category_id);
        $Recursive = new Recursive($category_data);
        $htmlSelectOptionCategory = $Recursive->categoryRecursive($id=0, $str="", $category_id);
        return view('admin.product.edit', compact('product', 'htmlSelectOptionCategory', 'htmlSelectOptionTag'));
    }

    public function update(request $request, $id) {
        $this->validate($request, [
			'name' => 'required'
        ],[
            'required' => 'Không được để trống'
        ]);
        $product = product::find($id);
        $dataProductUpdate = [
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'selling_price' => $request->selling_price,
            'trending' => $request->trending?"1":"0",
            'status' => $request->status?"1":"0",
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ];
        if ($request->hasFile('feature_image_path')) {
            if (Storage::exists($product->feature_image_path)) {
                Storage::delete($product->feature_image_path);
            }
            $fileName = rand(100, 100000) . $request->feature_image_path->getClientOriginalName();
            $avt_path= $request->feature_image_path->storeAs('product', $fileName);
            $dataProductUpdate['feature_image_path'] = $avt_path;
        }
        $product->update($dataProductUpdate);

        if ($request->hasFile('image_path')) {
            $product_images = product_image::where('product_id', $product->id)->get();
            foreach ($product_images as $product_image) {
                if(Storage::exists($product_image->image_path)) {
                    Storage::delete($product_image->image_path);
                }
            }
            product_image::where('product_id', $product->id)->delete();
            foreach ($request->image_path as $item) {
                $image_name = rand(100, 100000). $item->getClientOriginalName();
                $image_path = $item->storeAs('product', $image_name);
                $product->product_images()->create([
                    'image_path' => $image_path,
                ]);
            }
        }
        if ($request->tags) { 
            foreach ($request->tags as $tagItem) {
               $tag = tag::firstOrCreate(['name' => $tagItem]);
               $tagId[] = $tag->id;     
            }
                $product->tags()->sync($tagId);
        }
        return redirect()->route('admin-product')->with('status', 'Cập nhật sản phẩm thành công');
    }

    public function delete($id) {
        product::destroy($id);
        $countActive = product::all()->count();
        $countTrash = product::onlyTrashed()->count();
        return response()->json([
            'countActive' => $countActive,
            'countTrash' => $countTrash
        ], 200);
    }

    public function restore ($id) {
        product::onlyTrashed()->where('id', $id)->restore();
        $countActive = product::all()->count();
        $countTrash = product::onlyTrashed()->count();
        return response()->json([
            'countActive' => $countActive,
            'countTrash' => $countTrash
        ], 200);
    }

    public function force($id) {
        $product = product::withTrashed()->find($id);
        if($product->feature_image_path) {
            if(Storage::exists($product->feature_image_path)) {
                Storage::delete($product->feature_image_path);
            }
        }
        $product_images = product_image::where('product_id', $product->id)->get();
        foreach ($product_images as $product_image) {
            if(Storage::exists($product_image->image_path)) {
                Storage::delete($product_image->image_path);
            }
        }
        product::onlyTrashed()->where('id', $id)->forceDelete();
        $countActive = product::all()->count();
        $countTrash = product::onlyTrashed()->count();
        return response()->json([
            'countActive' => $countActive,
            'countTrash' => $countTrash
        ], 200);
    }

    public function updatetrending(request $request, $id) {
        $product = product::find($id);
        $product->update([
            'trending' => $request->trending
        ]);
        return response()->json([
            'message' => 'Đã cập nhật thay đổi',
            'value' => $request->trending,
        ]);
    }
    public function updatestatus(request $request, $id) {
        $product = product::find($id);
        $product->update([
            'status' => $request->status
        ]);
        return response()->json([
            'message' => 'Đã cập nhật thay đổi',
            'value' => $request->status,
        ]);
    }
}
