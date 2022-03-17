<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\product;
use App\Models\slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'home']);
            return $next($request);
        });
    }

    function index() {
        $sliders = slider::where('active', 'on')->latest()->get();
        $lastProducts = product::where('status', true)->latest()->get()->take(8);
        $productSellings = product::where(['trending' => true, 'status' => true])->get()->take(8);
        return view('client.home.index', compact('sliders', 'lastProducts', 'productSellings'));
    }
}
