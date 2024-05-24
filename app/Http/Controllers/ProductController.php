<?php

namespace App\Http\Controllers;

Use App\Models\Product;

class ProductController extends Controller
{

    public function getProduct(){
        $products = Product::all();
        // return view('product.index');
        return view('product.index', compact('products'));
    }
}