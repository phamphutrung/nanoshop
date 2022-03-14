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

        // related product:
        $idCategory = optional($product->category)->id;
        $products = product::where('trending', true)->get();
        $relatedProducts = [];
        foreach ($products as $productItem) {
            if ($productItem->category->id == $idCategory) {
                $relatedProducts[] = $productItem;
            }
        }

        $popularProducts = product::inRandomOrder()->where('trending', true)->limit(4)->get(); // popular (trending) product
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
                'avt' => $product->feature_image_path
            ]
        ]);

        return response()->json([Cart::content(), 'cartCount' => Cart::count(), 'msg' => 'Đã thêm sản phẩm vào giỏ hàng']);
    }
}
