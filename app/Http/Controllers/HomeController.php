<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $wishlistProductIds = [];
        if ($request->user()?->role === 'customer') {
            $wishlistProductIds = Wishlist::where('user_id', $request->user()->id)->pluck('product_id')->all();
        }

        return view('home', [
            'products' => Product::with(['seller', 'images'])
                ->whereIn('status', ['active', 'approved'])
                ->orderByDesc('created_at')
                ->take(8)
                ->get(),
            'categories' => Category::latest()->get(),
            'wishlistProductIds' => $wishlistProductIds,
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
