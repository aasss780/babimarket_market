<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $items = Wishlist::with('product.category', 'product.images')->where('user_id', $request->user()->id)->get();
        return view('wishlist', compact('items'));
    }

    public function store(Request $request, Product $product)
    {
        if ($request->user()->role !== 'customer') {
            return back()->withErrors(['wishlist' => 'Only customers can use the wishlist.']);
        }

        $existing = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();

            return back()->with('success', 'Removed from wishlist.');
        }

        Wishlist::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Added to wishlist.');
    }

    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }
        $wishlist->delete();
        return back()->with('success', 'Removed from wishlist.');
    }
}
