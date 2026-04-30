<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - BabiMarket</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary:#FF6F43; --bg:#FBF9F6; --dark:#1A1A1A; --gray:#7A7A7A; --white:#FFFFFF; --border:#EFEFEF; }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background-color:var(--bg); color:var(--dark); line-height:1.6; }
        .container { width:90%; max-width:1200px; margin:0 auto; }
        a { text-decoration:none; color:inherit; }
        .breadcrumb { padding:30px 0; font-size:13px; color:var(--gray); }
        .breadcrumb span { margin:0 10px; }
        .breadcrumb .current { color:var(--dark); font-weight:600; }
        .product-main { display:grid; grid-template-columns:1fr 1fr; gap:60px; margin-bottom:60px; background:var(--white); padding:40px; border-radius:30px; }
        @media (max-width: 900px) { .product-main { grid-template-columns:1fr; } }
        .gallery-main { width:100%; height:500px; object-fit:cover; border-radius:20px; margin-bottom:15px; display:block; }
        .gallery-placeholder { width:100%; height:500px; border-radius:20px; background:#EFEFEF; border:1px dashed var(--border); display:flex; align-items:center; justify-content:center; color:#BDBDBD; font-size:48px; }
        .gallery-thumbs { display:grid; grid-template-columns:repeat(auto-fill, minmax(72px, 1fr)); gap:12px; }
        .gallery-thumb { padding:0; border:2px solid transparent; border-radius:12px; overflow:hidden; cursor:pointer; background:var(--white); line-height:0; }
        .gallery-thumb img { width:100%; height:80px; object-fit:cover; display:block; }
        .gallery-thumb.active { border-color:var(--primary); }
        .product-badge { background:#E8F5E9; color:#4CAF50; padding:5px 12px; border-radius:5px; font-size:12px; font-weight:700; display:inline-block; margin-bottom:15px; }
        .product-title { font-size:32px; font-weight:800; line-height:1.2; margin-bottom:15px; }
        .product-meta { display:flex; flex-wrap:wrap; align-items:center; gap:16px; margin-bottom:20px; font-size:14px; }
        .rating-stars { color:#FFC107; letter-spacing:2px; }
        .rating-stars .far { color:#E0E0E0; }
        .rating-meta { color:var(--gray); font-weight:500; }
        .no-reviews { color:var(--gray); font-size:14px; }
        .sku { color:var(--gray); }
        .price-box { margin-bottom:25px; display:flex; align-items:center; gap:15px; }
        .current-price { font-size:32px; font-weight:800; color:var(--primary); }
        .old-price { font-size:20px; color:#BBB; text-decoration:line-through; }
        .short-desc { color:var(--gray); font-size:15px; margin-bottom:30px; padding-bottom:30px; border-bottom:1px solid var(--border); }
        .action-row { display:flex; flex-wrap:wrap; gap:12px; margin-top:24px; align-items:stretch; }
        .action-row form { display:flex; flex:1 1 calc(50% - 6px); min-width:140px; }
        .action-row a.btn-action { flex:1 1 calc(50% - 6px); min-width:140px; }
        .btn-action { width:100%; min-height:52px; padding:0 20px; border-radius:999px; font-weight:700; font-size:14px; cursor:pointer; transition:0.25s; display:inline-flex; align-items:center; justify-content:center; gap:8px; border:2px solid var(--primary); text-align:center; }
        .btn-action--primary { background:var(--primary); color:var(--white); }
        .btn-action--primary:hover { filter:brightness(0.95); }
        .btn-action--primary:disabled { opacity:0.45; cursor:not-allowed; filter:none; border-color:#CCC; background:#E0E0E0; color:#777; }
        .btn-action--ghost { background:var(--white); color:var(--primary); }
        .btn-action--ghost:hover { background:#FFF0EB; }
        .btn-action--ghost.is-saved { background:#FF5252; border-color:#FF5252; color:#fff; }
        .btn-action--ghost.is-saved:hover { filter:brightness(1.05); color:#fff; }
        .btn-action--ghost.is-saved i { color:#fff; }
        .oos-inline { flex:1 1 100%; padding:12px 16px; border-radius:14px; background:#FFEBEE; color:#B71C1C; font-size:14px; font-weight:600; border:1px solid #FFCDD2; }
        .product-badge--oos { background:#FFEBEE !important; color:#C62828 !important; }
        .section-card { background:var(--white); padding:40px; border-radius:30px; margin-bottom:40px; border:1px solid var(--border); }
        .section-card h2 { font-size:22px; font-weight:800; margin-bottom:16px; }
        .section-card p { color:#555; font-size:15px; }
        .section-title { font-size:28px; font-weight:800; margin-bottom:30px; }
        .grid-products { display:grid; grid-template-columns:repeat(4,1fr); gap:25px; margin-bottom:80px; }
        @media (max-width: 900px) { .grid-products { grid-template-columns:repeat(2,1fr); } }
        .product-card { background:var(--white); padding:15px; border-radius:25px; border:1px solid var(--border); }
        .p-img { height:220px; width:100%; object-fit:cover; border-radius:15px; margin-bottom:15px; display:block; }
        .p-img--placeholder { background:#EFEFEF; display:flex; align-items:center; justify-content:center; color:#CFCFCF; font-size:40px; }
        .p-title { font-size:14px; font-weight:700; margin-bottom:8px; min-height:40px; overflow:hidden; }
        .p-price { font-size:16px; font-weight:800; color:var(--primary); }
        .review-item { border-top:1px solid var(--border); padding-top:14px; margin-top:14px; }
        .review-item:first-of-type { border-top:none; padding-top:0; margin-top:0; }
    </style>
</head>
<body>
@include('partials.navbar')
<div class="container">
    @include('partials.alerts')
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a> <span>/</span>
        <a href="{{ route('products.index') }}">Products</a> <span>/</span>
        <span class="current">{{ $product->name }}</span>
    </div>
    <section class="product-main">
        <div class="gallery">
            @php
                $galleryUrls = $product->gallery_image_urls;
                $mainSrc = $galleryUrls[0] ?? null;
            @endphp
            @if($mainSrc)
                <img id="product-main-img" src="{{ $mainSrc }}" class="gallery-main" alt="{{ $product->name }}">
            @else
                <div id="product-main-placeholder" class="gallery-placeholder" role="img" aria-label="No product image"><i class="fas fa-image"></i></div>
            @endif
            @if(count($galleryUrls) > 1)
                <div class="gallery-thumbs" id="gallery-thumbs">
                    @foreach($galleryUrls as $idx => $url)
                        <button type="button" class="gallery-thumb {{ $idx === 0 ? 'active' : '' }}" data-src="{{ $url }}" aria-label="Show image {{ $idx + 1 }}">
                            <img src="{{ $url }}" alt="">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="product-info">
            <span class="product-badge {{ $product->isInStock() ? '' : 'product-badge--oos' }}">{{ $product->isInStock() ? 'In Stock' : 'Out of Stock' }}</span>
            <h1 class="product-title">{{ $product->name }}</h1>
            <div class="product-meta">
                @if(($product->reviews_count ?? 0) > 0)
                    @php
                        $avg = (float) ($product->reviews_avg_rating ?? 0);
                    @endphp
                    <div class="rating-stars" aria-label="Average rating {{ number_format($avg, 1) }} out of 5">
                        @for($i = 1; $i <= 5; $i++)
                            @if($avg >= $i)
                                <i class="fas fa-star"></i>
                            @elseif($avg >= $i - 0.5)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="rating-meta">{{ number_format($avg, 1) }} / 5 · {{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }}</span>
                @else
                    <span class="no-reviews">No reviews yet. Be the first to review this product.</span>
                @endif
                <div class="sku">Seller: {{ $product->seller->store_name ?? $product->seller->name ?? 'Unknown' }}</div>
            </div>
            <div class="price-box">
                <span class="current-price">${{ number_format($product->price,2) }}</span>
                @if($product->old_price)<span class="old-price">${{ number_format($product->old_price,2) }}</span>@endif
            </div>
            <p class="short-desc">{{ $product->description }}</p>
            @auth
                @if(auth()->user()->role === 'customer')
                <div class="action-row">
                    @if($product->isInStock())
                        <form method="POST" action="{{ route('cart.store', $product->id) }}">@csrf
                            <button class="btn-action btn-action--primary" type="submit"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                        </form>
                        <form method="POST" action="{{ route('cart.buy_now', $product->id) }}">@csrf
                            <button class="btn-action btn-action--primary" type="submit"><i class="fas fa-bolt"></i> Buy Now</button>
                        </form>
                    @else
                        <div class="oos-inline">This item is out of stock. You can still contact the seller or save it to your wishlist.</div>
                    @endif
                    <form method="POST" action="{{ route('wishlist.store', $product->id) }}">@csrf
                        <button class="btn-action btn-action--ghost {{ in_array($product->id, $wishlistProductIds ?? [], true) ? 'is-saved' : '' }}" type="submit"><i class="{{ in_array($product->id, $wishlistProductIds ?? [], true) ? 'fas' : 'far' }} fa-heart"></i> {{ in_array($product->id, $wishlistProductIds ?? [], true) ? 'Saved' : 'Wishlist' }}</button>
                    </form>
                    <a href="{{ route('messages.product', $product) }}" class="btn-action btn-action--ghost"><i class="fas fa-envelope"></i> Contact Seller</a>
                </div>
                @endif
            @endauth
            @auth
                @if(auth()->user()->role !== 'customer')
                    <div style="color:#c62828;font-size:13px;margin-top:10px;">Only customer accounts can buy products.</div>
                @endif
            @endauth
            @guest
                <div style="display:flex;gap:10px;align-items:center;margin-top:10px;flex-wrap:wrap;flex-direction:column;align-items:flex-start;">
                    <span style="color:#555;font-size:13px;">Please login to buy products or save to your wishlist.</span>
                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                        <a href="{{ route('login') }}" class="btn-action btn-action--ghost" style="max-width:260px;">Login to shop</a>
                        <a href="{{ route('login', ['wishlist' => 1]) }}" class="btn-action btn-action--ghost" style="max-width:260px;"><i class="far fa-heart"></i> Save to wishlist</a>
                    </div>
                </div>
            @endguest
        </div>
    </section>

    <section class="section-card">
        <h2>Product details</h2>
        <p>{{ $product->description }}</p>
        <p style="margin-top:16px;color:var(--gray);font-size:14px;">Standard shipping applies. Returns accepted within 14 days where applicable.</p>
    </section>

    <section class="section-card">
        <h2>Reviews @if(($product->reviews_count ?? 0) > 0)<span style="color:var(--gray);font-weight:600;font-size:16px;">({{ $product->reviews_count }})</span>@endif</h2>
        @if(($product->reviews_count ?? 0) > 0)
            <p style="margin-bottom:16px;color:var(--gray);">Average {{ number_format((float)($product->reviews_avg_rating ?? 0), 1) }} out of 5 based on {{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }}.</p>
        @else
            <p class="no-reviews" style="margin-bottom:16px;">No reviews yet. Be the first to review this product.</p>
        @endif
        @foreach($product->reviews as $review)
            <div class="review-item">
                <strong>{{ $review->user->name }}</strong>
                <span style="color:#FFC107;">{{ str_repeat('★', (int) $review->rating) }}{{ str_repeat('☆', max(0, 5 - (int) $review->rating)) }}</span>
                <div style="font-size:12px;color:var(--gray);">{{ $review->created_at?->format('M d, Y') }}</div>
                @if($review->comment)<p style="margin-top:8px;">{{ $review->comment }}</p>@endif
            </div>
        @endforeach
        @auth
            @if(auth()->user()->role === 'customer')
                <form method="POST" action="{{ route('products.reviews.store', $product->id) }}" style="margin-top:20px;">
                    @csrf
                    <label style="font-weight:600;font-size:14px;">Rating
                        <select name="rating" style="padding:8px;border:1px solid var(--border);border-radius:8px;margin-top:6px;display:block;">
                            <option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                        </select>
                    </label>
                    <div style="margin-top:8px;">
                        <textarea name="comment" placeholder="Write your comment" style="width:100%;padding:10px;border:1px solid var(--border);border-radius:8px;"></textarea>
                    </div>
                    <button class="btn-action btn-action--primary" type="submit" style="margin-top:12px;width:auto;min-width:200px;">Submit review</button>
                </form>
            @endif
        @else
            <p style="margin-top:12px;color:var(--gray);">Please login to write a review.</p>
        @endauth
    </section>

    <h2 class="section-title">You may also like</h2>
    <div class="grid-products">
        @foreach($relatedProducts as $related)
            <a href="{{ route('products.show', $related->id) }}" class="product-card">
                @if($related->primary_image_url)
                    <img src="{{ $related->primary_image_url }}" class="p-img" alt="{{ $related->name }}">
                @else
                    <div class="p-img p-img--placeholder" aria-hidden="true"><i class="fas fa-image"></i></div>
                @endif
                <div class="p-title">{{ $related->name }}</div>
                <div class="p-price">${{ number_format($related->price,2) }}</div>
            </a>
        @endforeach
    </div>
</div>
@if(count($galleryUrls) > 1)
<script>
(function(){
    var main = document.getElementById('product-main-img');
    var thumbs = document.querySelectorAll('.gallery-thumb');
    if (!main || !thumbs.length) return;
    thumbs.forEach(function(btn){
        btn.addEventListener('click', function(){
            var src = this.getAttribute('data-src');
            if (src) main.src = src;
            thumbs.forEach(function(b){ b.classList.remove('active'); });
            this.classList.add('active');
        });
    });
})();
</script>
@endif
</body>
</html>
