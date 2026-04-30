<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'seller', 'images'])
            ->whereIn('status', ['active', 'approved']);
        if ($request->filled('search')) {
            $search = (string) $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->integer('category'));
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        $sort = (string) $request->input('sort', 'newest');
        if ($sort === '') {
            $sort = 'newest';
        }

        if (in_array($sort, ['price_low', 'price_asc'], true)) {
            $query->orderBy('price')->orderByDesc('created_at');
        } elseif (in_array($sort, ['price_high', 'price_desc'], true)) {
            $query->orderByDesc('price')->orderByDesc('created_at');
        } elseif ($sort === 'top_rated') {
            $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating')->orderByDesc('created_at');
        } elseif ($sort === 'most_popular') {
            $query->withCount('reviews')->orderByDesc('reviews_count')->orderByDesc('created_at');
        } else {
            $query->orderByDesc('created_at');
        }

        $products = $query->withCount('reviews')->withAvg('reviews', 'rating')->paginate(12)->withQueryString();

        $wishlistProductIds = [];
        if ($request->user()?->role === 'customer') {
            $wishlistProductIds = Wishlist::where('user_id', $request->user()->id)->pluck('product_id')->all();
        }

        return view('products.index', [
            'products' => $products,
            'categories' => Category::all(),
            'wishlistProductIds' => $wishlistProductIds,
        ]);
    }

    public function show(Request $request, $id)
    {
        $productQuery = Product::with(['seller', 'category', 'reviews.user', 'images'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if ($request->user()?->role !== 'admin' && $request->user()?->role !== 'seller') {
            $productQuery->whereIn('status', ['active', 'approved']);
        }

        $product = $productQuery->findOrFail($id);

        $wishlistProductIds = [];
        if ($request->user()?->role === 'customer') {
            $wishlistProductIds = Wishlist::where('user_id', $request->user()->id)->pluck('product_id')->all();
        }

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => Product::with('images')
                ->whereIn('status', ['active', 'approved'])
                ->where('id', '!=', $product->id)
                ->orderByDesc('created_at')
                ->take(4)
                ->get(),
            'wishlistProductIds' => $wishlistProductIds,
        ]);
    }

    public function storeReview(Request $request, $id)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $product = Product::findOrFail($id);
        Review::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $product->id],
            $data
        );

        return back()->with('success', 'Review submitted successfully.');
    }
}
