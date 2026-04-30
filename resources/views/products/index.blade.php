<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BabiMarket - All Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary:#FF6F43; --bg-color:#FBF9F6; --text-dark:#1A1A1A; --text-gray:#7A7A7A; --white:#FFFFFF; --border-color:#EFEFEF; }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background-color:var(--bg-color); color:var(--text-dark); line-height:1.55; }
        .page-wrap { width:92%; max-width:1240px; margin:0 auto; padding-bottom:64px; }
        a { color:inherit; }
        .page-header { padding:28px 0 8px; }
        .page-header h1 { font-size:clamp(26px,4vw,32px); font-weight:800; letter-spacing:-0.02em; }
        .breadcrumb { font-size:13px; color:var(--text-gray); margin-top:8px; }
        .breadcrumb span { color:var(--primary); font-weight:600; }
        .shop-layout { display:grid; grid-template-columns:minmax(0,280px) minmax(0,1fr); gap:36px; align-items:start; margin-top:24px; }
        @media (max-width:960px) {
            .shop-layout { grid-template-columns:1fr; gap:28px; }
        }
        .sidebar { background:var(--white); padding:24px; border-radius:18px; border:1px solid var(--border-color); box-shadow:0 4px 24px rgba(0,0,0,0.04); position:sticky; top:88px; }
        @media (max-width:960px) {
            .sidebar { position:static; }
        }
        .filter-section { margin-bottom:22px; padding-bottom:22px; border-bottom:1px solid var(--border-color); }
        .filter-section:last-of-type { border-bottom:none; margin-bottom:0; padding-bottom:0; }
        .filter-title { font-size:14px; font-weight:700; margin-bottom:12px; color:var(--text-dark); text-transform:uppercase; letter-spacing:0.04em; }
        .search-box { display:flex; align-items:center; gap:10px; background:#F9F9F9; border:1px solid var(--border-color); border-radius:12px; padding:12px 14px; transition:border-color .2s; }
        .search-box:focus-within { border-color:var(--primary); background:var(--white); }
        .search-box i { color:var(--text-gray); font-size:15px; flex-shrink:0; }
        .search-box input { border:none; background:transparent; outline:none; width:100%; font-size:14px; color:var(--text-dark); }
        .search-box input::placeholder { color:#AAA; }
        .radio-group { display:flex; flex-direction:column; gap:10px; max-height:280px; overflow-y:auto; padding-right:4px; }
        .radio-label { display:flex; align-items:center; gap:10px; font-size:14px; color:var(--text-dark); cursor:pointer; padding:8px 10px; border-radius:10px; transition:background .15s; }
        .radio-label:hover { background:#F9F9F9; }
        .radio-label input { width:17px; height:17px; accent-color:var(--primary); cursor:pointer; flex-shrink:0; }
        .filter-select { width:100%; padding:12px 14px; border:1px solid var(--border-color); border-radius:12px; font-size:14px; font-family:inherit; color:var(--text-dark); background:#F9F9F9; cursor:pointer; appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%237A7A7A' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 14px center; padding-right:36px; }
        .filter-select:focus { outline:none; border-color:var(--primary); background-color:var(--white); }
        .price-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
        .price-input { width:100%; border:1px solid var(--border-color); border-radius:12px; padding:11px 12px; font-size:14px; background:#F9F9F9; color:var(--text-dark); }
        .price-input:focus { outline:none; border-color:var(--primary); background:var(--white); }
        .btn-filter { width:100%; margin-top:14px; padding:12px 16px; background:var(--primary); color:var(--white); border:none; border-radius:12px; font-weight:600; font-size:14px; cursor:pointer; transition:opacity .2s, transform .15s; }
        .btn-filter:hover { opacity:.92; }
        .btn-filter:active { transform:scale(0.99); }
        .btn-clear { width:100%; margin-top:10px; padding:11px 16px; background:#FFF; color:var(--text-dark); border:1px solid var(--border-color); border-radius:12px; font-weight:600; font-size:14px; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; }
        .btn-clear:hover { border-color:var(--primary); color:var(--primary); background:#FFF8F5; }
        .shop-main { min-width:0; }
        .shop-top-bar { display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:14px; margin-bottom:22px; background:var(--white); padding:16px 20px; border-radius:16px; border:1px solid var(--border-color); box-shadow:0 4px 20px rgba(0,0,0,0.03); }
        .results-count { font-size:14px; color:var(--text-gray); }
        .results-count strong { color:var(--text-dark); font-weight:600; }
        .sort-summary { font-size:14px; color:var(--text-gray); }
        .sort-summary strong { color:var(--text-dark); font-weight:600; }
        .products-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:22px; }
        .product-card { background:var(--white); border-radius:18px; border:1px solid var(--border-color); position:relative; display:flex; flex-direction:column; min-height:100%; overflow:hidden; transition:box-shadow .25s, border-color .25s, transform .2s; }
        .product-card:hover { box-shadow:0 12px 36px rgba(0,0,0,0.08); border-color:#E8E8E8; transform:translateY(-3px); }
        .product-card__link { position:absolute; inset:0; z-index:1; border-radius:18px; }
        .product-card__inner { position:relative; z-index:2; display:flex; flex-direction:column; flex:1; padding:14px; pointer-events:none; }
        .product-card__inner button, .product-card__inner .product-card__interactive { pointer-events:auto; }
        .product-img-box { position:relative; border-radius:14px; overflow:hidden; background:#F0F0F0; aspect-ratio:1/1; margin-bottom:12px; }
        .product-img-box img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .35s ease; }
        .product-card:hover .product-img-box img { transform:scale(1.04); }
        .btn-wishlist { position:absolute; top:10px; right:10px; background:var(--white); border:1px solid var(--border-color); width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:15px; color:var(--text-gray); cursor:pointer; transition:color .2s, border-color .2s, box-shadow .2s, background .2s; box-shadow:0 2px 8px rgba(0,0,0,0.06); z-index:4; text-decoration:none; }
        .btn-wishlist:hover { color:var(--primary); border-color:var(--primary); }
        .btn-wishlist.is-saved { background:#FF5252; border-color:#FF5252; color:#fff; }
        .btn-wishlist.is-saved:hover { filter:brightness(1.05); color:#fff; }
        .oos-badge { position:absolute; left:10px; bottom:10px; z-index:3; background:rgba(26,26,26,0.88); color:#fff; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; padding:6px 10px; border-radius:8px; }
        .btn-add-cart:disabled { opacity:.45; cursor:not-allowed; background:#9E9E9E !important; }
        .btn-add-cart:disabled:hover { background:#9E9E9E !important; }
        .product-category { font-size:11px; color:var(--primary); font-weight:700; text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px; }
        .product-title { font-size:15px; font-weight:700; color:var(--text-dark); line-height:1.35; margin-bottom:6px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .rating-line { font-size:12px; color:var(--text-gray); margin-bottom:10px; min-height:18px; }
        .product-bottom { display:flex; justify-content:space-between; align-items:center; gap:10px; margin-top:auto; padding-top:4px; }
        .product-price { font-size:18px; font-weight:800; color:var(--text-dark); }
        .old-price { font-size:13px; color:var(--text-gray); text-decoration:line-through; margin-left:6px; font-weight:500; }
        .btn-add-cart { background:var(--text-dark); color:var(--white); border:none; width:42px; height:42px; border-radius:12px; font-size:16px; cursor:pointer; transition:background .2s; display:flex; align-items:center; justify-content:center; }
        .btn-add-cart:hover { background:var(--primary); }
        .product-actions { display:flex; flex-wrap:wrap; gap:8px; margin-top:12px; }
        .product-actions a { font-size:13px; font-weight:600; padding:8px 12px; border-radius:10px; text-decoration:none; transition:background .2s, color .2s; }
        .product-actions .btn-view { background:#FFF0EB; color:var(--primary); border:1px solid transparent; }
        .product-actions .btn-view:hover { background:var(--primary); color:var(--white); }
        .product-actions .btn-contact { background:var(--white); color:var(--text-dark); border:1px solid var(--border-color); }
        .product-actions .btn-contact:hover { border-color:var(--primary); color:var(--primary); }
        .bm-pagination { margin-top:28px; padding-top:20px; border-top:1px solid var(--border-color); display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px; }
        .bm-pagination__list { list-style:none; display:flex; flex-wrap:wrap; align-items:center; gap:6px; }
        .bm-pagination__item { display:inline-flex; align-items:center; justify-content:center; min-width:40px; height:40px; padding:0 10px; border-radius:10px; border:1px solid var(--border-color); background:var(--white); color:var(--text-dark); font-size:14px; font-weight:600; text-decoration:none; transition:background .15s, border-color .15s, color .15s; }
        a.bm-pagination__item:hover { border-color:var(--primary); color:var(--primary); background:#FFF8F5; }
        .bm-pagination__item--current { background:var(--primary); border-color:var(--primary); color:var(--white); }
        .bm-pagination__item--disabled { opacity:.45; cursor:not-allowed; color:var(--text-gray); }
        .bm-pagination__item--dots { border:none; background:transparent; min-width:auto; padding:0 4px; }
        .bm-pagination__meta { font-size:13px; color:var(--text-gray); margin:0; }
        .bm-pagination__meta strong { color:var(--text-dark); font-weight:600; }
    </style>
</head>
<body>
@include('partials.navbar')
<div class="page-wrap">
    @include('partials.alerts')
    <header class="page-header">
        <h1>All Products</h1>
        <div class="breadcrumb">Home / <span>Shop</span></div>
    </header>
    <div class="shop-layout">
        <aside class="sidebar">
            <form method="GET" action="{{ route('products.index') }}">
                <div class="filter-section">
                    <h3 class="filter-title">Search</h3>
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        <input type="text" name="search" placeholder="Search products…" value="{{ request('search') }}" autocomplete="off">
                    </div>
                </div>
                <div class="filter-section">
                    <h3 class="filter-title">Categories</h3>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="category" value="" @checked(!request()->filled('category'))>
                            All categories
                        </label>
                        @foreach($categories as $category)
                            <label class="radio-label">
                                <input type="radio" name="category" value="{{ $category->id }}" @checked((string)request('category')===(string)$category->id)>
                                {{ $category->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="filter-section">
                    <h3 class="filter-title">Price range</h3>
                    <div class="price-grid">
                        <input class="price-input" type="number" step="0.01" min="0" name="min_price" placeholder="Min" value="{{ request('min_price') }}">
                        <input class="price-input" type="number" step="0.01" min="0" name="max_price" placeholder="Max" value="{{ request('max_price') }}">
                    </div>
                </div>
                <div class="filter-section">
                    <h3 class="filter-title">Sort</h3>
                    <select class="filter-select" name="sort">
                        <option value="newest" @selected(blank(request('sort')) || request('sort')==='newest')>Newest first</option>
                        <option value="price_low" @selected(in_array(request('sort'), ['price_low', 'price_asc'], true))>Price: Low to High</option>
                        <option value="price_high" @selected(in_array(request('sort'), ['price_high', 'price_desc'], true))>Price: High to Low</option>
                        <option value="top_rated" @selected(request('sort')==='top_rated')>Top rated</option>
                        <option value="most_popular" @selected(request('sort')==='most_popular')>Most popular</option>
                    </select>
                    <button class="btn-filter" type="submit">Apply filters</button>
                    @if(request()->hasAny(['search', 'category', 'sort', 'min_price', 'max_price']))
                        <a class="btn-clear" href="{{ route('products.index') }}">Clear filters</a>
                    @endif
                </div>
            </form>
        </aside>
        <main class="shop-main">
            @php
                $sortParam = request('sort');
                $sortLabel = match (true) {
                    blank($sortParam) || $sortParam === 'newest' => 'Newest first',
                    in_array($sortParam, ['price_low', 'price_asc'], true) => 'Price: Low to High',
                    in_array($sortParam, ['price_high', 'price_desc'], true) => 'Price: High to Low',
                    $sortParam === 'top_rated' => 'Top rated',
                    $sortParam === 'most_popular' => 'Most popular',
                    default => 'Newest first',
                };
            @endphp
            <div class="shop-top-bar">
                <p class="results-count">
                    @if($products->total())
                        Showing <strong>{{ $products->firstItem() }}</strong>–<strong>{{ $products->lastItem() }}</strong> of <strong>{{ $products->total() }}</strong> products
                    @else
                        <strong>0</strong> products
                    @endif
                </p>
                <p class="sort-summary">Sort: <strong>{{ $sortLabel }}</strong></p>
            </div>
            @php
                $wishlistIds = $wishlistProductIds ?? [];
            @endphp
            @if($products->count())
            <div class="products-grid">
                @foreach($products as $product)
                    @php
                        $inWishlist = in_array($product->id, $wishlistIds, true);
                        $canBuy = $product->isInStock();
                    @endphp
                    <article class="product-card">
                        <a href="{{ route('products.show', $product->id) }}" class="product-card__link" aria-label="View {{ $product->name }}"></a>
                        <div class="product-card__inner">
                            <div class="product-img-box">
                                @if($product->primary_image_url)
                                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}">
                                @else
                                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#BDBDBD;font-size:34px;"><i class="fa-regular fa-image"></i></div>
                                @endif
                                @if(! $canBuy)
                                    <span class="oos-badge">Out of stock</span>
                                @endif
                                @guest
                                    <a href="{{ route('login', ['wishlist' => 1]) }}" class="btn-wishlist product-card__interactive" title="Login to save" aria-label="Login to save to wishlist"><i class="fa-regular fa-heart" aria-hidden="true"></i></a>
                                @else
                                    @if(auth()->user()->role === 'customer')
                                        <form method="POST" action="{{ route('wishlist.store', $product->id) }}" class="product-card__interactive">
                                            @csrf
                                            <button class="btn-wishlist {{ $inWishlist ? 'is-saved' : '' }}" type="submit" title="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}" aria-label="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}"><i class="{{ $inWishlist ? 'fa-solid fa-heart' : 'fa-regular fa-heart' }}" aria-hidden="true"></i></button>
                                        </form>
                                    @endif
                                @endguest
                            </div>
                            @if($product->category)
                                <div class="product-category">{{ $product->category->name }}</div>
                            @endif
                            <h2 class="product-title">{{ $product->name }}</h2>
                            @if(($product->reviews_count ?? 0) > 0)
                                <div class="rating-line">★ {{ number_format((float)($product->reviews_avg_rating ?? 0), 1) }} <span style="color:var(--text-gray);">({{ $product->reviews_count }} {{ $product->reviews_count === 1 ? 'review' : 'reviews' }})</span></div>
                            @else
                                <div class="rating-line" aria-hidden="true"></div>
                            @endif
                            <div class="product-bottom">
                                <div>
                                    <span class="product-price">${{ number_format($product->price, 2) }}</span>
                                    @if($product->old_price)
                                        <span class="old-price">${{ number_format($product->old_price, 2) }}</span>
                                    @endif
                                </div>
                                @auth
                                    @if(auth()->user()->role === 'customer')
                                        <form method="POST" action="{{ route('cart.store', $product->id) }}" class="product-card__interactive">
                                            @csrf
                                            <button class="btn-add-cart" type="submit" title="Add to cart" aria-label="Add to cart" @if(! $canBuy) disabled @endif><i class="fa-solid fa-cart-plus" aria-hidden="true"></i></button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                            <div class="product-actions product-card__interactive">
                                <a href="{{ route('products.show', $product->id) }}" class="btn-view">View</a>
                                @auth
                                    @if(auth()->user()->role === 'customer')
                                        <a href="{{ route('messages.product', $product) }}" class="btn-contact">Contact seller</a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            @else
                <div style="background:#fff;border:1px solid var(--border-color);border-radius:16px;padding:36px 20px;text-align:center;">
                    <h3 style="margin:0 0 6px;font-size:22px;">No products found</h3>
                    <p style="margin:0;color:var(--text-gray);">Try changing your filters or search term.</p>
                    <a class="btn-clear" href="{{ route('products.index') }}" style="margin-top:16px;max-width:220px;">Back to Products</a>
                </div>
            @endif
            {{ $products->links('pagination.babimarket') }}
        </main>
    </div>
</div>
</body>
</html>
