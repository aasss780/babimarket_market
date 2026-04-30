<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $items = $cart->items()->with('product.images')->get();
        return view('cart.index', compact('items'));
    }

    public function store(Request $request, Product $product)
    {
        if ($request->user()->role !== 'customer') {
            return back()->withErrors(['cart' => 'Only customers can add products to cart.']);
        }

        if ($product->status !== 'active') {
            return back()->withErrors(['cart' => 'This product is not available.']);
        }

        if (! $product->isInStock()) {
            return back()->withErrors(['cart' => 'This product is out of stock.']);
        }

        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $item = $cart->items()->where('product_id', $product->id)->first();
        $currentQty = $item?->quantity ?? 0;
        $requestedQty = $currentQty + 1;

        if (! $product->hasStockFor($requestedQty)) {
            return back()->withErrors([
                'cart' => "Only {$product->stock} items available for {$product->name}.",
            ]);
        }

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function buyNow(Request $request, Product $product)
    {
        if ($request->user()->role !== 'customer') {
            return back()->withErrors(['cart' => 'Only customers can buy products.']);
        }

        if ($product->status !== 'active') {
            return back()->withErrors(['cart' => 'This product is not available.']);
        }

        if (! $product->isInStock()) {
            return back()->withErrors(['cart' => 'This product is out of stock.']);
        }

        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $item = $cart->items()->where('product_id', $product->id)->first();
        $currentQty = $item?->quantity ?? 0;
        $requestedQty = $currentQty + 1;

        if (! $product->hasStockFor($requestedQty)) {
            return back()->withErrors([
                'cart' => "Only {$product->stock} items available for {$product->name}.",
            ]);
        }

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);
        }

        return redirect()->route('checkout.index')->with('success', 'Product added to cart. Continue checkout.');
    }

    public function destroy(CartItem $item)
    {
        $item->delete();
        return back()->with('success', 'Removed from cart');
    }
}
