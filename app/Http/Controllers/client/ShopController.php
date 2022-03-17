<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'shop']);
            return $next($request);
        });
    }
    function index($slug = 0, $id = 0)
    {
        $categoryParents = category::where('parent_id', 0)->latest()->get();
        $popularProducts = product::inRandomOrder()
                            ->where(['trending' => true, 'status' => true])
                            ->limit(6)->get(); // popular (trending) product
        if ($id != 0) {
            $category = category::find($id);
            $category_name = $category->name;
            $products = $category->products()->latest()->paginate(40);
            return view('client.shop.index', compact('categoryParents', 'category_name', 'products', 'popularProducts'));
        }

        $category_name = "Tất cả sản phẩm";
        $products = product::latest()->paginate(40);
        return view('client.shop.index', compact('categoryParents', 'category_name', 'products', 'popularProducts'));
    }

    function addToCart(request $request)
    {
        $product = product::find($request->id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->selling_price,
            'weight' => 0,
            'options' => [
                'avt' => $product->feature_image_path,
                'slug' => $product->slug,
            ]
        ]);

        return response()->json(['cartCount' => Cart::count(), 'msg' => 'Đã thêm sản phẩm vào giỏ hàng']);
    }
}
