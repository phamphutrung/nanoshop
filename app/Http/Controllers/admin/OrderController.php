<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }

    function index(request $request)
    {
        if ($request->user()->cannot('view', Order::class)) {
            return redirect()->back()->with('notification', 'Bạn không có quyền truy cập');
        } else {
            $orders = Order::latest()->paginate(40);
            return view('admin.order.index', compact('orders'));
        }
    }

    function getDetail(request $request)
    {
        $order = Order::find($request->id);

        $viewMainOrder = view('admin.order.inc.main_info_order', compact('order'))->render();

        $productItems = $order->products;
        $viewMainCart = view('admin.order.inc.main_cart', compact('productItems'))->render();

        return response()->json(['viewMainOrder' => $viewMainOrder, 'viewMainCart' => $viewMainCart]);
    }

    function updateStatus(request $request)
    {
        Order::where('id', $request->id)->update(['status' => $request->val]);
        $orders = Order::latest()->paginate(40);
        $view = view('admin.order.inc.main_data', compact('orders'))->render();
        return response()->json(['msg' => 'Đã cập nhật trạng thái đơn hàng', 'view' => $view]);
    }

    function delete(request $request)
    {
        if ($request->user()->cannot('delete', Order::class)) {
            return response()->json(['code'=> -1, 'msg'=>'Bạn không có quyền xóa']);
        } else {
            $order = Order::find($request->id);
            $order->products()->detach();
            Order::destroy($request->id);
            $orders = Order::latest()->paginate(40);
            $view = view('admin.order.inc.main_data', compact('orders'))->render();
            return response()->json(['msg' => 'Đã xóa đơn hàng', 'view' => $view]);
        }
    }

    public function filter(request $request)
    {
        $str = $request->search_string;

        $stt = $request->status;
        $orders = Order::where(function ($q) use ($str) {
            $q->where("code", "like", "%$str%")
                ->orWhere("name", "like", "%$str%")
                ->orWhere('created_at', 'like', "$str");
        })->when($stt, function ($q) use ($stt) {
            $q->where('status', $stt);
        })->latest()->paginate(40);

        $view = view('admin.order.inc.main_data', compact('orders'))->render();
        return response()->json(['view' => $view]);
    }
}
