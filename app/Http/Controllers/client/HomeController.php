<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use App\Models\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'home']);
            return $next($request);
        });
    }

    function index()
    {
        $sliders = slider::where('active', 'on')->latest()->get();
        $lastProducts = product::where('status', true)->latest()->get()->take(8);
        $productSellings = product::where(['trending' => true, 'status' => true])->get()->take(8);
        $categories =  category::all();

        return view('client.home.index', compact('sliders', 'lastProducts', 'productSellings', 'categories'));
    }

    function search(request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);
        $categoryParents = category::where('parent_id', 0)->latest()->get();
        $str = $request->search;
        $products = product::where('name', 'like', "%$str%")->get();
        return view('client.shop.search', compact('products', 'str', 'categoryParents'));
    }

    function searchDropdown(request $request)
    {
        $str = $request->str;
        $products = product::where('name', 'like', "%$str%")->get();
        $view = view('layouts\inc_client\search_data', compact('products'))->render();

        return response()->json(['view' => $view]);
    }
}
