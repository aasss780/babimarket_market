<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BabiMarket | الصفحة الرئيسية</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #FF6F43; --bg-color: #FBF9F6; --text-dark: #1A1A1A; --text-gray: #7A7A7A; --white: #FFFFFF; --border-color: #EFEFEF; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--bg-color); color: var(--text-dark); line-height: 1.6; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }
        a { text-decoration: none; transition: 0.3s; }
        img { max-width: 100%; border-radius: 20px; }
        .section-padding { padding: 80px 0; }
        .sub-title { color: var(--text-gray); font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; display: block; margin-bottom: 10px; }
        .main-title { font-size: 32px; font-weight: 800; color: var(--text-dark); margin-bottom: 40px; }
        .hero { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; padding: 60px 0; }
        .hero h1 { font-size: 55px; font-weight: 800; line-height: 1.1; margin-bottom: 25px; }
        .hero h1 span { color: var(--primary); }
        .hero p { color: var(--text-gray); font-size: 16px; margin-bottom: 40px; max-width: 480px; }
        .hero-btns { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 50px; }
        .btn { padding: 16px 32px; border-radius: 50px; font-weight: 700; font-size: 15px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 10px; border: none; }
        .btn-primary { background: var(--primary); color: var(--white); }
        .btn-outline { background: transparent; border: 2px solid #E0DCD3; color: var(--text-dark); }
        .hero-stats { display: flex; gap: 40px; border-top: 1px solid #E0DCD3; padding-top: 30px; flex-wrap: wrap; }
        .stat h3 { font-size: 26px; font-weight: 800; color: var(--text-dark); }
        .stat span { font-size: 13px; color: var(--text-gray); font-weight: 500; }
        .hero-img { width: 100%; height: 550px; object-fit: cover; box-shadow: 0 20px 40px rgba(0,0,0,0.08); border-radius: 20px; }
        .categories-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 20px; }
        .cat-card { background: var(--white); padding: 30px 15px; border-radius: 20px; text-align: center; cursor: pointer; transition: 0.3s; border: 1px solid var(--border-color); color: inherit; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
        .cat-card:hover { transform: translateY(-8px); box-shadow: 0 10px 25px rgba(0,0,0,0.06); }
        .cat-icon { font-size: 32px; margin-bottom: 15px; display: block; }
        .cat-card h4 { font-size: 14px; font-weight: 700; margin-bottom: 5px; }
        .cat-card p { font-size: 12px; color: var(--text-gray); margin: 0; }
        .section-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 16px; }
        .view-all { color: var(--primary); font-weight: 700; font-size: 14px; display: inline-flex; align-items: center; gap: 5px; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 25px; }
        .product-card { background: var(--white); padding: 15px; border-radius: 25px; position: relative; transition: 0.3s; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
        .product-card:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.06); }
        .clickable-card { cursor: pointer; }
        .badge-sale { position: absolute; top: 25px; left: 25px; background: #FF5252; color: white; font-size: 11px; font-weight: bold; padding: 4px 12px; border-radius: 20px; z-index: 2; }
        .product-img { width: 100%; height: 220px; object-fit: cover; border-radius: 15px; margin-bottom: 15px; }
        .product-img-ph { width: 100%; height: 220px; border-radius: 15px; background: #EFEFEF; display: flex; align-items: center; justify-content: center; color: #CCC; font-size: 42px; margin-bottom: 15px; }
        .brand { font-size: 12px; color: var(--text-gray); font-weight: 600; display: flex; align-items: center; gap: 5px; margin-bottom: 5px; }
        .product-title { font-size: 15px; font-weight: 700; line-height: 1.4; margin-bottom: 8px; min-height: 42px; }
        .price-wrapper { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .current-price { font-size: 18px; font-weight: 800; }
        .old-price { font-size: 14px; color: #AAA; text-decoration: line-through; }
        .add-to-cart { width: 100%; border: 2px solid var(--primary); background: transparent; color: var(--primary); padding: 10px; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; transition: 0.3s; }
        .add-to-cart:hover { background: var(--primary); color: white; }
        .add-to-cart:disabled { opacity: 0.45; cursor: not-allowed; border-color: #CCC; color: #999; background: #F5F5F5; }
        .add-to-cart:disabled:hover { background: #F5F5F5; color: #999; }
        .product-media-wrap { position: relative; }
        .oos-pill { position: absolute; left: 12px; bottom: 12px; z-index: 2; background: rgba(26,26,26,0.88); color: #fff; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; padding: 5px 10px; border-radius: 8px; }
        .wishlist-fab { position: absolute; top: 12px; right: 12px; z-index: 3; width: 38px; height: 38px; border-radius: 50%; border: 1px solid var(--border-color); background: #fff; display: flex; align-items: center; justify-content: center; color: var(--text-gray); font-size: 15px; cursor: pointer; text-decoration: none; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: 0.2s; }
        .wishlist-fab:hover { color: var(--primary); border-color: var(--primary); }
        .wishlist-fab.is-saved { background: #FF5252; border-color: #FF5252; color: #fff; }
        .wishlist-fab.is-saved:hover { filter: brightness(1.05); color: #fff; }
        .why-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; }
        .why-card { background: var(--white); border-radius: 20px; padding: 28px 24px; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0,0,0,0.03); transition: 0.25s; }
        .why-card:hover { box-shadow: 0 12px 32px rgba(0,0,0,0.06); transform: translateY(-4px); }
        .why-card i { font-size: 28px; color: var(--primary); margin-bottom: 14px; }
        .why-card h3 { font-size: 17px; font-weight: 700; margin-bottom: 8px; }
        .why-card p { font-size: 14px; color: var(--text-gray); line-height: 1.55; }
        .steps-wrap { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; counter-reset: step; }
        .step-card { background: var(--white); border-radius: 16px; padding: 22px 18px; border: 1px solid var(--border-color); text-align: center; position: relative; box-shadow: 0 4px 16px rgba(0,0,0,0.03); }
        .step-num { width: 36px; height: 36px; border-radius: 50%; background: #FFF0EB; color: var(--primary); font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 14px; }
        .step-card strong { display: block; font-size: 14px; margin-bottom: 6px; }
        .step-card span { font-size: 12px; color: var(--text-gray); }
        .benefit-panel { background: var(--white); border-radius: 24px; padding: 40px 36px; border: 1px solid var(--border-color); box-shadow: 0 8px 30px rgba(0,0,0,0.04); }
        .benefit-panel h2 { margin-bottom: 10px; }
        .benefit-panel > p { color: var(--text-gray); margin-bottom: 24px; max-width: 640px; }
        .benefit-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .benefit-item { display: flex; gap: 12px; align-items: flex-start; padding: 14px 16px; border-radius: 14px; background: var(--bg-color); border: 1px solid var(--border-color); }
        .benefit-item i { color: var(--primary); margin-top: 2px; }
        .benefit-item span { font-size: 14px; color: var(--text-dark); font-weight: 500; }
        .trust-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        .trust-card { background: var(--white); border-radius: 18px; padding: 24px; border: 1px solid var(--border-color); box-shadow: 0 4px 18px rgba(0,0,0,0.03); }
        .trust-card i { color: var(--primary); font-size: 22px; margin-bottom: 10px; }
        .trust-card h3 { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
        .trust-card p { font-size: 13px; color: var(--text-gray); line-height: 1.5; }
        .empty-state { text-align: center; padding: 48px 24px; background: var(--white); border-radius: 20px; border: 1px dashed var(--border-color); color: var(--text-gray); }
        .site-footer { background: var(--white); border-top: 1px solid var(--border-color); padding: 56px 0 28px; margin-top: 0; }
        .footer-grid { display: grid; grid-template-columns: 1.4fr 1fr 1fr 1fr; gap: 36px; margin-bottom: 40px; }
        @media (max-width: 900px) {
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .hero { grid-template-columns: 1fr; }
            .hero-img { height: 360px; }
            .hero h1 { font-size: 38px; }
        }
        @media (max-width: 520px) {
            .footer-grid { grid-template-columns: 1fr; }
        }
        .footer-brand p { color: var(--text-gray); font-size: 14px; margin-top: 12px; line-height: 1.65; max-width: 320px; }
        .footer-col h4 { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-dark); margin-bottom: 16px; }
        .footer-col a, .footer-col p { display: block; font-size: 14px; color: var(--text-gray); margin-bottom: 10px; }
        .footer-col a:hover { color: var(--primary); }
        .footer-bottom { border-top: 1px solid var(--border-color); padding-top: 22px; text-align: center; font-size: 13px; color: var(--text-gray); }
        .footer-cta { background: #322C29; padding: 80px 0; text-align: center; color: white; margin-top: 0; }
        .footer-cta h2 { font-size: 38px; font-weight: 800; margin-bottom: 15px; }
        .footer-cta p { color: #AFAFAF; font-size: 16px; margin-bottom: 35px; max-width: 600px; margin-inline: auto; }
        .footer-cta .btn-row { display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; }
    </style>
</head>
<body>
@include('partials.navbar')
<div class="container">
    @include('partials.alerts')
    <section class="hero">
        <div class="hero-content">
            <h1>Everything Your <br><span>Little One Needs</span></h1>
            <p>Curated marketplace connecting parents with trusted sellers offering premium baby products.</p>
            <div class="hero-btns">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping <i class="fa-solid fa-arrow-right"></i></a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-outline">Become a Seller</a>
                @else
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('wishlist.index') }}" class="btn btn-outline">My Wishlist</a>
                    @endif
                @endguest
            </div>
            <div class="hero-stats">
                <div class="stat"><h3>{{ $products->count() }}+</h3><span>Products</span></div>
                <div class="stat"><h3>{{ $categories->count() }}+</h3><span>Categories</span></div>
                <div class="stat"><h3>24/7</h3><span>Support</span></div>
            </div>
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=800&auto=format&fit=crop" alt="Mother and Baby" class="hero-img">
        </div>
    </section>

    <section class="section-padding" style="padding-bottom: 40px;">
        <span class="sub-title">/ WHY US</span>
        <h2 class="main-title">Why Choose BabiMarket?</h2>
        <div class="why-grid">
            <div class="why-card">
                <i class="fa-solid fa-store"></i>
                <h3>Trusted Sellers</h3>
                <p>Shop from verified sellers who list quality baby essentials with clear descriptions and fair pricing.</p>
            </div>
            <div class="why-card">
                <i class="fa-solid fa-shield-heart"></i>
                <h3>Safe Baby Products</h3>
                <p>We focus on products families trust—designed for comfort, safety, and peace of mind.</p>
            </div>
            <div class="why-card">
                <i class="fa-solid fa-bag-shopping"></i>
                <h3>Easy Shopping</h3>
                <p>Browse categories, save favorites, and check out with a simple flow built for busy parents.</p>
            </div>
            <div class="why-card">
                <i class="fa-solid fa-comments"></i>
                <h3>Fast Communication</h3>
                <p>Message sellers directly about any product—questions answered before you buy.</p>
            </div>
        </div>
    </section>

    <section class="section-padding" style="padding-top: 0; padding-bottom: 40px;">
        <span class="sub-title">/ PROCESS</span>
        <h2 class="main-title">How It Works</h2>
        <div class="steps-wrap">
            <div class="step-card"><div class="step-num">1</div><strong>Browse Products</strong><span>Explore categories and listings from multiple sellers.</span></div>
            <div class="step-card"><div class="step-num">2</div><strong>Contact or Cart</strong><span>Message the seller or add items to your cart.</span></div>
            <div class="step-card"><div class="step-num">3</div><strong>Place Order</strong><span>Enter delivery details and choose payment (demo).</span></div>
            <div class="step-card"><div class="step-num">4</div><strong>Seller Confirms</strong><span>Sellers review and accept or update your order.</span></div>
            <div class="step-card"><div class="step-num">5</div><strong>Receive</strong><span>Track status and enjoy your baby essentials.</span></div>
        </div>
    </section>

    <section class="section-padding" style="padding-top: 0;">
        <span class="sub-title">/ EXPLORE</span>
        <h2 class="main-title">Featured Categories</h2>
        <div class="categories-grid">
            @forelse($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="cat-card">
                    <i class="fa-solid fa-baby cat-icon" style="color:#FF7043;"></i>
                    <h4>{{ $category->name }}</h4>
                    <p>Explore items</p>
                </a>
            @empty
                <div class="empty-state" style="grid-column: 1 / -1;">Categories will appear here once added by an admin.</div>
            @endforelse
        </div>
    </section>

    <section class="section-padding" style="padding-top: 0;">
        <div class="section-header">
            <div>
                <span class="sub-title">/ MARKETPLACE</span>
                <h2 class="main-title" style="margin-bottom:0;">New Arrivals &amp; Top Picks</h2>
                <p style="color:var(--text-gray);font-size:14px;margin-top:10px;max-width:520px;">Latest active listings from our sellers—updated as new products go live.</p>
            </div>
            <a href="{{ route('products.index') }}" class="view-all">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        @if($products->isEmpty())
            <div class="empty-state">No products yet. Check back soon or register as a seller to list items.</div>
        @else
            @php
                $wishlistIds = $wishlistProductIds ?? [];
            @endphp
            <div class="products-grid">
                @foreach($products as $product)
                    @php
                        $inWishlist = in_array($product->id, $wishlistIds, true);
                        $canBuy = $product->isInStock();
                    @endphp
                    <div class="product-card clickable-card" data-href="{{ route('products.show', $product->id) }}">
                        @if($product->old_price)<span class="badge-sale">Sale</span>@endif
                        <div class="product-media-wrap">
                            @if(! $canBuy)
                                <span class="oos-pill">Out of stock</span>
                            @endif
                            @if($product->primary_image_url)
                                <img src="{{ $product->primary_image_url }}" class="product-img" alt="{{ $product->name }}">
                            @else
                                <div class="product-img-ph" aria-hidden="true"><i class="fa-solid fa-image"></i></div>
                            @endif
                            @guest
                                <a href="{{ route('login', ['wishlist' => 1]) }}" class="wishlist-fab" onclick="event.stopPropagation();" title="Login to save" aria-label="Login to save to wishlist"><i class="fa-regular fa-heart"></i></a>
                            @else
                                @if(auth()->user()->role === 'customer')
                                    <form method="POST" action="{{ route('wishlist.store', $product->id) }}" onclick="event.stopPropagation();" style="position:absolute;top:12px;right:12px;z-index:3;margin:0;">
                                        @csrf
                                        <button type="submit" class="wishlist-fab {{ $inWishlist ? 'is-saved' : '' }}" title="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}" aria-label="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}"><i class="{{ $inWishlist ? 'fa-solid fa-heart' : 'fa-regular fa-heart' }}"></i></button>
                                    </form>
                                @endif
                            @endguest
                        </div>
                        <div class="brand">{{ $product->seller->store_name ?? $product->seller->name ?? 'Seller' }}</div>
                        <h3 class="product-title"><a href="{{ route('products.show', $product->id) }}" style="color:inherit;">{{ $product->name }}</a></h3>
                        <div class="price-wrapper">
                            <span class="current-price">${{ number_format($product->price, 2) }}</span>
                            @if($product->old_price)<span class="old-price">${{ number_format($product->old_price, 2) }}</span>@endif
                        </div>
                        @auth
                            @if(auth()->user()->role === 'customer')
                                <form method="POST" action="{{ route('cart.store', $product->id) }}" onclick="event.stopPropagation();">
                                    @csrf
                                    <button class="add-to-cart" type="submit" @if(! $canBuy) disabled @endif>{{ $canBuy ? 'Add to Cart' : 'Out of Stock' }}</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    @guest
        <section class="section-padding" style="padding-top: 0;">
            <div class="benefit-panel">
                <span class="sub-title">/ FOR SELLERS</span>
                <h2 class="main-title" style="margin-bottom: 12px;">Grow with BabiMarket</h2>
                <p>Open a seller account to reach parents looking for trusted baby products—manage listings and orders in one place.</p>
                <div class="benefit-list">
                    <div class="benefit-item"><i class="fa-solid fa-user-plus"></i><span>Create a seller account</span></div>
                    <div class="benefit-item"><i class="fa-solid fa-box"></i><span>Add and edit your products</span></div>
                    <div class="benefit-item"><i class="fa-solid fa-clipboard-list"></i><span>Manage incoming orders</span></div>
                    <div class="benefit-item"><i class="fa-solid fa-bullhorn"></i><span>Reach customers across categories</span></div>
                </div>
                <a href="{{ route('register') }}" class="btn btn-primary">Become a Seller <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </section>
    @else
        @if(auth()->user()->role === 'customer')
            <section class="section-padding" style="padding-top: 0;">
                <div class="benefit-panel">
                    <span class="sub-title">/ FOR YOU</span>
                    <h2 class="main-title" style="margin-bottom: 12px;">Shopping made simple</h2>
                    <p>Save items, follow orders, and chat with sellers whenever you need more details.</p>
                    <div class="benefit-list">
                        <div class="benefit-item"><i class="fa-solid fa-heart"></i><span>Save favorites to your wishlist</span></div>
                        <div class="benefit-item"><i class="fa-solid fa-truck-fast"></i><span>Track your orders from your account</span></div>
                        <div class="benefit-item"><i class="fa-solid fa-envelope"></i><span>Message sellers about any product</span></div>
                    </div>
                    <div class="hero-btns" style="margin-bottom:0;">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="{{ route('wishlist.index') }}" class="btn btn-outline">My Wishlist</a>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline">My Orders</a>
                    </div>
                </div>
            </section>
        @endif
    @endguest

    <section class="section-padding" style="padding-top: 0;">
        <span class="sub-title">/ TRUST</span>
        <h2 class="main-title">Shop with confidence</h2>
        <div class="trust-grid">
            <div class="trust-card">
                <i class="fa-solid fa-lock"></i>
                <h3>Secure demo checkout</h3>
                <p>Try the checkout flow with demo payment validation—no real card data is stored.</p>
            </div>
            <div class="trust-card">
                <i class="fa-solid fa-star"></i>
                <h3>Product reviews</h3>
                <p>See ratings and feedback from other customers on product pages.</p>
            </div>
            <div class="trust-card">
                <i class="fa-solid fa-list-check"></i>
                <h3>Order tracking</h3>
                <p>Follow order status as sellers process and update your purchase.</p>
            </div>
            <div class="trust-card">
                <i class="fa-solid fa-message"></i>
                <h3>Direct messaging</h3>
                <p>Reach sellers in context of each product for clear, fast answers.</p>
            </div>
        </div>
    </section>
</div>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <div style="display:flex;align-items:center;gap:10px;font-weight:800;font-size:20px;color:#1E3A34;">
                <span style="background:#4CAF50;color:#fff;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;font-size:15px;">B</span>
                BabiMarket
            </div>
            <p>A friendly marketplace for baby essentials—connecting parents with trusted sellers in one cream-and-orange experience.</p>
        </div>
        <div class="footer-col">
            <h4>Shop</h4>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('products.index') }}">Products</a>
            <a href="{{ route('about') }}">About</a>
        </div>
        <div class="footer-col">
            <h4>Account</h4>
            @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @else
                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('profile') }}">Profile</a>
                    <a href="{{ route('wishlist.index') }}">Wishlist</a>
                    <a href="{{ route('orders.index') }}">Orders</a>
                @endif
            @endguest
        </div>
        <div class="footer-col">
            <h4>Contact</h4>
            <p>support@babimarket.com</p>
            <p>+1 (555) 123-4567</p>
            <p>123 Baby Street</p>
        </div>
    </div>
    <div class="container footer-bottom">
        &copy; {{ date('Y') }} BabiMarket. All rights reserved. Demo project for internship.
    </div>
</footer>

<footer class="footer-cta">
    <div class="container">
        @guest
            <h2>Ready to Start Selling?</h2>
            <p>Join sellers on BabiMarket and reach parents looking for quality baby products.</p>
            <div class="btn-row">
                <a href="{{ route('register') }}" class="btn btn-primary">Become a Seller <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        @else
            @if(auth()->user()->role === 'customer')
                <h2>Continue Shopping for Your Baby</h2>
                <p>Discover handpicked products from trusted stores.</p>
                <div class="btn-row">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products <i class="fa-solid fa-arrow-right"></i></a>
                    <a href="{{ route('wishlist.index') }}" class="btn btn-outline" style="border-color:rgba(255,255,255,0.35);color:#fff;">My Wishlist</a>
                </div>
            @endif
        @endguest
    </div>
</footer>
<script>
document.querySelectorAll('.clickable-card').forEach(function(card){
    card.addEventListener('click', function(e){
        if(e.target.closest('button') || e.target.closest('form') || e.target.closest('a')) return;
        window.location.href = card.getAttribute('data-href');
    });
});
</script>
</body>
</html>
