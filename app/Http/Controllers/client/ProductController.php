<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'shop']);
            return $next($request);
        });
    }

    function index($slug, $id)
    {
        $product = product::where('status', true)->find($id); //main product.

        $relatedProducts = $product->category->products()->where('trending', true)->get(); // lấy danh mục của sản phẩm chính sau đó lấy những sản phẩm trong danh mục vừa lấy ra

        $popularProducts = product::inRandomOrder()->where(['trending' => true, 'status' => true])->limit(5)->get(); // popular (trending) product
        return view('client.product.index', compact('product', 'relatedProducts', 'popularProducts'));
    }
    function addCart(request $request)
    {
        $product = product::find($request->idProduct);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty,
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
