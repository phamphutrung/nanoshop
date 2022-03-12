<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    

    function index() {
        $lastProducts = product::where('status', true)->latest()->get()->take(8);
        return view('client.home.index', compact('lastProducts'));
    }
}
