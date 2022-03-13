<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'cart']);
            return $next($request);
        });
    }

    function index() {
        $popularProducts = product::inRandomOrder()->where('trending', true)->limit(10)->get();
        return view('client.cart.index', compact('popularProducts'));
    }
    function deleteItem(request $request) {
        Cart::remove($request->rowId);
        $noti = view('client.cart.noti_cart_empty')->render();
        return response()->json(['msg' => 'đã xóa', 'cartCount' => Cart::count(), 'noti' => $noti]);
    }
    function updateItem(request $request) {
        Cart::update($request->rowId, $request->qty);
        $itemTotal = Cart::get($request->rowId)->total;
        $cartTotal = Cart::total();
        $cartCount = Cart::count();
        return response()->json(['itemTotal' => $itemTotal, 'cartTotal' => $cartTotal, 'cartCount' => $cartCount]);
    }
}
