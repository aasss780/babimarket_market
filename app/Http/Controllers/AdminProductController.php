<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        return view('admin.products', ['products' => Product::with(['seller', 'images'])->latest()->get()]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }
}
