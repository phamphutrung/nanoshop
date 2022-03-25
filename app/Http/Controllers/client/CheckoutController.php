<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'checkout']);
            return $next($request);
        });
    }

    function index()
    {
        $popularProducts = product::inRandomOrder()->where('trending', true)->limit(10)->get();
        return view('client.checkout.index', compact('popularProducts'));
    }

    function order(request $request)
    {
        if (Cart::count() > 0) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ], ['required' => 'Không được để trống :attribute'], [
                'name' => 'tên', 'phone' => 'số điện thoại', 'address' => 'địa chỉ'
            ]);
            if ($validator->fails()) {
                return response()->json(['code' => 0, 'errors' => $validator->errors()->toArray()]);
            } else {
                $dataOrder = $request->all();
                $dataOrder['code'] = '#' . Str::random(9);
                $dataOrder['total'] = Cart::total();
                $order = Order::create($dataOrder);

                foreach (Cart::content() as $item) {
                    $order->products()->attach($item->id, ['qty' => $item->qty, 'total' => $item->total]);
                }
                Cart::destroy();
                $view = view('client.checkout.inc.thanks')->render();
                return response()->json(['view' => $view]);
            }
        } else {
            return response()->json(['code' => -1, 'msg' => 'Bạn chưa thêm sản phẩm vào giỏ hàng!']);
        }
    }
}
