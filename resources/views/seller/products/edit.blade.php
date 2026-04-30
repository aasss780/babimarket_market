@extends('layouts.seller')

@section('content')
    <div class="card">
        <h2 style="margin-bottom:14px;">Edit Product</h2>
        <form method="POST" action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="width:120px;height:120px;border-radius:12px;overflow:hidden;background:#F2F2F2;border:1px solid #EFEFEF;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
                @if($product->primary_image_url)
                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <i class="fa-regular fa-image" style="color:#B0B0B0;font-size:24px;"></i>
                @endif
            </div>
            <label>Name<input name="name" value="{{ $product->name }}" required></label>
            <label style="margin-top:10px;">Description<textarea name="description" required>{{ $product->description }}</textarea></label>
            <div class="grid" style="margin-top:10px;">
                <label>Price<input name="price" type="number" step="0.01" value="{{ $product->price }}" required></label>
                <label>Stock<input name="stock" type="number" value="{{ $product->stock }}" required></label>
            </div>
            <label style="margin-top:10px;">Replace image (JPG, PNG, WEBP, max 4MB)
                <input name="main_image" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
            </label>
            <button class="btn" style="margin-top:12px;" type="submit">Update Product</button>
        </form>
    </div>
@endsection
