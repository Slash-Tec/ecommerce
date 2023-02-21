<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
