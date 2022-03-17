<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    
    function index () {
        return view('client.checkout.index');
    }

    function order (request $request) {
        return response()->json($request->all());
    }
}
