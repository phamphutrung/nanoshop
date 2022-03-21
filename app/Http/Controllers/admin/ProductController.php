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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }
    public function index(request $request)
    {
        $data = category::all();
        $Recursive = new Recursive($data);
        $htmlSelectOptionCategory = $Recursive->categoryRecursive($id = '0', $tr = '', '');

        $tags = tag::all();
        $getHtml = new GetHtml;
        $htmlSelectOptionTag = $getHtml->getHtmlTags($tags, []);

        $products = product::latest()->paginate(100);
        return view('admin.product.index', compact('products', 'htmlSelectOptionCategory', 'htmlSelectOptionTag'));
    }

    function gerRecord()
    {
    }

    public function viewProductDetail(request $request)
    {
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



    public function insert(request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
            'selling_price' => 'integer'
        ], ['required' => 'Không được để trống', 'integer' => 'Định dạng giá không hợp lệ']);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $dataProductCreate = [
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'original_price' => $request->original_price,
                'selling_price' => $request->selling_price,
                'trending' => $request->trending ? "1" : "0",
                'status' => $request->status ? "1" : "0",
                'content' => $request->content,
                'category_id' => $request->category_id,
                'user_id' => Auth::id(),
            ];
            if ($request->hasFile('feature_image_path')) {
                $fileName = rand(100, 100000) . $request->feature_image_path->getClientOriginalName();
                $avt_path = $request->feature_image_path->storeAs('product', $fileName);
                $dataProductCreate['feature_image_path'] = $avt_path;
            }
            $product = product::create($dataProductCreate);

            if ($request->hasFile('image_path')) {
                foreach ($request->image_path as $item) {
                    $image_name = rand(100, 100000) . $item->getClientOriginalName();
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

            $products = product::latest()->paginate(500);
            $view = view('admin.product.main_data', compact('products'))->render();
            return response()->json([
                'msg' => 'Đã thêm sản phẩm',
                'view' => $view,
            ]);
        }
    }

    public function edit($id)
    {

        $product = product::find($id);
        $tags_array = [];
        foreach ($product->tags as $tagItem) {
            $tags_array[] = $tagItem->name;
        }
        $tag_data = tag::all();
        $getHtml = new getHtml;
        $htmlSelectOptionTag = $getHtml->getHtmlTags($tag_data, $tags_array);


        $category_data = Category::all();
        $category_id = $product->category ? $product->category->id : null;
        // dd($category_id);
        $Recursive = new Recursive($category_data);
        $htmlSelectOptionCategory = $Recursive->categoryRecursive($id = 0, $str = "", $category_id);
        return view('admin.product.edit', compact('product', 'htmlSelectOptionCategory', 'htmlSelectOptionTag'));
    }

    public function update(request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'name' => 'required',
            'slug' => 'required',
            'selling_price' => 'integer'
        ], [
            'required' => 'Không được để trống'
        ]);
        $product = product::find($id);
        $dataProductUpdate = [
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'selling_price' => $request->selling_price,
            'trending' => $request->trending ? "1" : "0",
            'status' => $request->status ? "1" : "0",
            'content' => $request->content,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ];
        if ($request->hasFile('feature_image_path')) {
            if (Storage::exists($product->feature_image_path)) {
                Storage::delete($product->feature_image_path);
            }
            $fileName = rand(100, 100000) . $request->feature_image_path->getClientOriginalName();
            $avt_path = $request->feature_image_path->storeAs('product', $fileName);
            $dataProductUpdate['feature_image_path'] = $avt_path;
        }
        $product->update($dataProductUpdate);

        if ($request->hasFile('image_path')) {
            $product_images = product_image::where('product_id', $product->id)->get();
            foreach ($product_images as $product_image) {
                if (Storage::exists($product_image->image_path)) {
                    Storage::delete($product_image->image_path);
                }
            }
            product_image::where('product_id', $product->id)->delete();
            foreach ($request->image_path as $item) {
                $image_name = rand(100, 100000) . $item->getClientOriginalName();
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

    public function delete(request $request)
    {
        product::destroy($request->id);
        $products = product::latest()->paginate(500);
        $view = view('admin.product.main_data', compact('products'))->render();
        return response()->json([
            'msg' => 'Đã xóa sản phẩm',
            'view' => $view,
        ]);
    }

    public function restore($id)
    {
        product::onlyTrashed()->where('id', $id)->restore();
        $countActive = product::all()->count();
        $countTrash = product::onlyTrashed()->count();
        return response()->json([
            'countActive' => $countActive,
            'countTrash' => $countTrash
        ], 200);
    }

    public function force($id)
    {
        $product = product::withTrashed()->find($id);
        if ($product->feature_image_path) {
            if (Storage::exists($product->feature_image_path)) {
                Storage::delete($product->feature_image_path);
            }
        }
        $product_images = product_image::where('product_id', $product->id)->get();
        foreach ($product_images as $product_image) {
            if (Storage::exists($product_image->image_path)) {
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

    public function updatetrending(request $request)
    {
        $product = product::find($request->id);
        $product->update([
            'trending' => $request->isTrending,
        ]);
        return response()->json([
            'msg' => 'Đã cập nhật xu hướng',
        ]);
    }
    public function updatestatus(request $request)
    {
        $product = product::find($request->id);
        $product->update([
            'status' => $request->isStatus,
        ]);
        return response()->json([
            'msg' => 'Đã cập nhật trạng thái kích hoạt',
        ]);
    }

    public function filter(request $request)
    {
        $str = $request->search_string;
        $cat = $request->idCat;
        // if ($cat) {
        //     $products = product::where("name", "like", "%{$str}%")->where('category_id', $cat)->paginate(500);
        // } else {
        //     $products = product::where("name", "like", "%{$str}%")->latest()->paginate(500);
        // }
        $products = product::where(function ($q) use ($str) {
            $q->where('name', 'like', "%$str%")->orWhere('selling_price', 'like', "%$str%");
        })->when($cat, function($q) use ($cat) {
            $q->where('category_id', $cat);
        })
            ->latest()->paginate(400);
        $view = view('admin.product.main_data', compact('products'))->render();
        return response()->json(['view' => $view]);
    }
}
