<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'images'])
            ->where('seller_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->get();
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        return view('seller.products.create', ['categories' => Category::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'old_price' => ['nullable', 'numeric'],
            'stock' => ['required', 'integer'],
            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }
        Product::create($data + ['seller_id' => $request->user()->id, 'status' => 'active']);
        return redirect()->route('seller.products.index');
    }

    public function edit(Request $request, $id)
    {
        $product = Product::where('seller_id', $request->user()->id)->findOrFail($id);
        return view('seller.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('seller_id', $request->user()->id)->findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer'],
            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        if ($request->hasFile('main_image')) {
            $oldImage = $product->main_image;
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
            if ($oldImage && $this->isLocalImagePath($oldImage)) {
                $oldPath = Str::startsWith($oldImage, 'storage/') ? Str::after($oldImage, 'storage/') : $oldImage;
                Storage::disk('public')->delete($oldPath);
            }
        }

        $product->update($data);
        return redirect()->route('seller.products.index');
    }

    private function isLocalImagePath(string $path): bool
    {
        return ! Str::startsWith($path, ['http://', 'https://']);
    }

    public function destroy(Request $request, $id)
    {
        Product::where('seller_id', $request->user()->id)->findOrFail($id)->delete();
        return back();
    }
}
