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

        $tags = tag::all();
        $getHtml = new GetHtml;
        $htmlSelectOptionTag = $getHtml->getHtmlTags($tags);
        
        return view('admin.product.add', compact('htmlSelectOptionCategory', 'htmlSelectOptionTag'));
    }

    public function insert(request $request) {
        $this->validate($request, [
			'name' => 'required'
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
            $fileName = $request->feature_image_path->getClientOriginalName();
            $avt_path= $request->feature_image_path->storeAs('public/product', $fileName);
            $dataProductCreate['feature_image_path'] = storage::url($avt_path);
        }
        $product = product::create($dataProductCreate);

        if ($request->hasFile('image_path')) {
            foreach ($request->image_path as $item) {
                $image_name = $item->getClientOriginalName();
                $image_path= $request->feature_image_path->storeAs('public/product', $image_name);
                $product->product_images()->create([
                    'image_path' => Storage::url($image_path),
                ]);
            }
        }
        if ($request->tags) {
            // $tags = tag::all();
         
            foreach ($request->tags as $tagItem) {
               $tag = tag::firstOrCreate(['name' => $tagItem]);
               product_tag::create([
                   'product_id' => $product->id,
                   'tag_id' => $tag->id,
               ]);
            }
            // dd($tag_ids);
        }
        // foreach ($request->tags as $tag) {
        //     // echo $tag;
        // }
    }
}
