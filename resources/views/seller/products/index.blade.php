@extends('layouts.seller')

@section('topbar_action')
    <a href="{{ route('seller.products.create') }}" class="btn"><i class="fa-solid fa-plus"></i> Add Product</a>
@endsection

@section('content')
    <h2 style="margin-bottom:14px;">My Products</h2>
    @forelse($products as $product)
        <div class="card" style="display:grid;grid-template-columns:110px 1fr auto;gap:14px;align-items:start;">
            <div style="width:110px;height:110px;border-radius:12px;overflow:hidden;background:#F2F2F2;border:1px solid #EFEFEF;display:flex;align-items:center;justify-content:center;">
                @if($product->primary_image_url)
                    <img src="{{ $product->primary_image_url }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <i class="fa-regular fa-image" style="color:#B0B0B0;font-size:24px;"></i>
                @endif
            </div>
            <div>
                <h3 style="margin-bottom:6px;">{{ $product->name }}</h3>
                <div class="muted">Category: {{ $product->category->name ?? 'N/A' }}</div>
                <div class="muted">Price: ${{ number_format($product->price,2) }} | Stock: {{ $product->stock }}@if((int)$product->stock <= 0) <span style="color:#c62828;font-weight:700;">(Out of Stock)</span>@endif | Status: {{ ucfirst($product->status) }}</div>
                <p style="margin-top:8px;color:#555;">{{ \Illuminate\Support\Str::limit($product->description, 120) }}</p>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="{{ route('seller.products.edit', $product->id) }}" class="btn">Edit</a>
                <form method="POST" action="{{ route('seller.products.destroy', $product->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="card"><p class="muted">No products yet. Start by adding your first product.</p></div>
    @endforelse
@endsection
