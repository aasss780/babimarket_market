@extends('layouts.seller')

@section('content')
    <div class="card">
        <h2 style="margin-bottom:14px;">Add Product</h2>
        <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid">
                <label>Name<input name="name" required></label>
                <label>Category<select name="category_id" required>@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></label>
            </div>
            <label style="margin-top:10px;">Description<textarea name="description" required></textarea></label>
            <div class="grid" style="margin-top:10px;">
                <label>Price<input name="price" type="number" step="0.01" required></label>
                <label>Old Price (optional)<input name="old_price" type="number" step="0.01"></label>
                <label>Stock<input name="stock" type="number" required></label>
            </div>
            <label style="margin-top:10px;">Image (JPG, PNG, WEBP, max 4MB)<input name="main_image" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"></label>
            <button class="btn" type="submit" style="margin-top:12px;">Save Product</button>
        </form>
    </div>
@endsection
