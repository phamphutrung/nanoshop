<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    

    function index($slug, $id) {
        $product = product::where('status', true)->find($id); //main product.

        // related product:
        $idCategory = $product->category->id;
        $products = product::where('trending', true)->get();
        $relatedProducts = []; 
        foreach ($products as $productItem) {
            if($productItem->category->id == $idCategory) {
                $relatedProducts[] = $productItem;
            }
        }

        $popularProducts = product::inRandomOrder()->where('trending', true)->limit(4)->get(); // popular (trending) product
        
        return view('client.product.index', compact('product', 'relatedProducts', 'popularProducts'));
    }
}
