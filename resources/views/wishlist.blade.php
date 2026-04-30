<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>BabiMarket - Wishlist</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root{--primary:#FF6F43;--bg-color:#FBF9F6;--text-dark:#1A1A1A;--text-gray:#7A7A7A;--border-color:#EFEFEF}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:var(--bg-color);color:var(--text-dark)}
.container{width:90%;max-width:1200px;margin:34px auto 70px}
.wishlist-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:25px}
.product-card{background:#fff;border-radius:24px;padding:15px;border:1px solid var(--border-color);position:relative;transition:.25s}
.product-card:hover{box-shadow:0 12px 30px rgba(0,0,0,.05);transform:translateY(-4px)}
.product-img{width:100%;height:220px;object-fit:cover;border-radius:14px;margin-bottom:14px}
.brand{font-size:12px;color:var(--text-gray);font-weight:600;margin-bottom:4px}
.product-title{font-size:15px;font-weight:700;margin-bottom:6px;line-height:1.4;min-height:42px}
.price{color:var(--text-dark);font-weight:800;font-size:18px;margin-bottom:12px}
.btn-row{display:flex;gap:8px}
.add-cart-btn{flex:1;padding:10px;background:var(--primary);color:#fff;border:none;border-radius:12px;font-weight:700;cursor:pointer}
.remove-btn{border:none;background:#FFF0EB;color:var(--primary);width:34px;height:34px;border-radius:50%;cursor:pointer}
.add-cart-btn:disabled{opacity:.45;cursor:not-allowed;background:#BDBDBD!important}
.oos-tag{display:inline-block;margin-bottom:8px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:#c62828;background:#FFEBEE;padding:4px 10px;border-radius:8px}
.empty{background:#fff;border:1px solid var(--border-color);border-radius:18px;padding:28px}
.empty p{color:var(--text-gray);margin:8px 0 14px}
.empty a{display:inline-flex;align-items:center;gap:8px;background:var(--primary);color:#fff;padding:10px 16px;border-radius:999px;text-decoration:none;font-weight:600}
</style></head><body>
@include('partials.navbar')
<div class="container">@include('partials.alerts')<h1 style="font-size:32px;font-weight:800;margin-bottom:26px;"><i class="fa-solid fa-heart" style="color:#FF5252;"></i> My Wishlist</h1>
<div class="wishlist-grid">
@forelse($items as $item)
@php
    $p = $item->product;
    $canBuy = $p && $p->isInStock();
@endphp
<div class="product-card">
    @if($p->primary_image_url)
        <img src="{{ $p->primary_image_url }}" class="product-img" alt="{{ $p->name }}">
    @else
        <div class="product-img" style="background:#EFEFEF;display:flex;align-items:center;justify-content:center;color:#CFCFCF;font-size:36px;"><i class="fa-regular fa-image"></i></div>
    @endif
    @if(! $canBuy)<div class="oos-tag">Out of stock</div>@endif
    <div class="brand">{{ $p->category->name ?? 'Category' }}</div>
    <h3 class="product-title">{{ $p->name }}</h3>
    <div class="price">${{ number_format($p->price,2) }}</div>
    <div class="btn-row">
        <form method="POST" action="{{ route('cart.store', $item->product_id) }}" style="flex:1;">@csrf<button class="add-cart-btn" type="submit" @if(! $canBuy) disabled @endif><i class="fa-solid fa-cart-shopping"></i> {{ $canBuy ? 'Add to Cart' : 'Unavailable' }}</button></form>
        <form method="POST" action="{{ route('wishlist.destroy', $item->id) }}">@csrf<button class="remove-btn" type="submit" title="Remove from wishlist"><i class="fa-solid fa-xmark"></i></button></form>
    </div>
</div>
@empty
<div class="empty">
    <h3>Your wishlist is empty.</h3>
    <p>Browse products and add your favorites here.</p>
    <a href="{{ route('products.index') }}"><i class="fa-solid fa-store"></i> Back to Products</a>
</div>
@endforelse
</div></div></body></html>
