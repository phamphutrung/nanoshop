<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\models\cart;
use Illuminate\Support\Facades\Session;

class testCart extends Controller
{
    public function add(request $request)
    {
        // // =========thêm=========
        // $product = product::find(45);
        // $oldCart = session('cart') ? session('cart') : null;
        // $newCart = new Cart($oldCart);
        // $newCart->addToCard($product);
        // session(['cart' => $newCart]);

        // // =========xóa==========
        // $oldCart = session('cart') ? session('cart') : null;
        // $newCart = new Cart($oldCart);
        // $newCart->deleteItem(44);
        // session(['cart' => $newCart]);
        
        // // ========cập nhật========
        // $oldCart = session('cart') ? session('cart') : null;
        // $newCart = new Cart($oldCart);
        // $newCart->updateItem(45, 10);
        // session(['cart' => $newCart]);
            
        //     dump(session('cart')) ;

    }
}
