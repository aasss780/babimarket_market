@php
    $wishlistCount = 0;
    $cartCount = 0;
    $notificationCount = 0;
    $messageCount = 0;
    if (auth()->check()) {
        $notificationCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count();
        if (auth()->user()->role === 'customer') {
            $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
            $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
            $cartCount = $cart ? $cart->items()->count() : 0;
            $messageCount = \App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count();
        }
    }
@endphp
<style>
    .bm-navbar{background:#fff;padding:18px 0;border-bottom:1px solid #EFEFEF;position:sticky;top:0;z-index:1000}
    .bm-container{width:90%;max-width:1200px;margin:0 auto}
    .bm-nav-flex{display:flex;justify-content:space-between;align-items:center;gap:12px}
    .bm-logo{display:flex;align-items:center;gap:10px;font-size:22px;font-weight:800;color:#1E3A34;text-decoration:none}
    .bm-logo-icon{background:#4CAF50;color:#fff;width:30px;height:30px;display:flex;justify-content:center;align-items:center;border-radius:8px;font-size:16px}
    .bm-nav-links,.bm-nav-right{display:flex;align-items:center;gap:20px;flex-wrap:wrap}
    .bm-link{color:#1A1A1A;font-size:15px;font-weight:500;text-decoration:none}
    .bm-link:hover,.bm-link.active{color:#FF6F43}
    .bm-pill{display:inline-flex;align-items:center;justify-content:center;min-width:18px;height:18px;padding:0 6px;border-radius:999px;background:#FF6F43;color:#fff;font-size:10px;font-weight:700;margin-left:6px}
    .bm-logout{border:none;background:transparent;color:#1A1A1A;font-size:15px;font-weight:500;cursor:pointer;padding:6px 10px;border-radius:8px;font-family:inherit;transition:background .2s,color .2s}
    .bm-logout:hover,.bm-logout:focus-visible{color:#FF6F43;background:rgba(255,111,67,0.12);outline:none}
</style>
<header class="bm-navbar">
    <div class="bm-container bm-nav-flex">
        <a class="bm-logo" href="{{ route('home') }}">
            <div class="bm-logo-icon">B</div>
            BabiMarket
        </a>
        <nav class="bm-nav-links">
            <a href="{{ route('home') }}" class="bm-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('products.index') }}" class="bm-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
            <a href="{{ route('about') }}" class="bm-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('contact') }}" class="bm-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
        </nav>
        <div class="bm-nav-right">
            @guest
                <a href="{{ route('login') }}" class="bm-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                <a href="{{ route('register') }}" class="bm-link {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
            @else
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="bm-link">Admin Dashboard</a>
                @elseif(auth()->user()->role === 'seller')
                    <a href="{{ route('seller.dashboard') }}" class="bm-link">Seller Dashboard</a>
                @else
                    <a href="{{ route('profile') }}" class="bm-link {{ request()->routeIs('profile') ? 'active' : '' }}">Profile</a>
                    <a href="{{ route('wishlist.index') }}" class="bm-link {{ request()->routeIs('wishlist.*') ? 'active' : '' }}">Wishlist <span class="bm-pill">{{ $wishlistCount }}</span></a>
                    <a href="{{ route('cart.index') }}" class="bm-link {{ request()->routeIs('cart.*') ? 'active' : '' }}">Cart <span class="bm-pill">{{ $cartCount }}</span></a>
                    <a href="{{ route('messages') }}" class="bm-link {{ request()->routeIs('messages') ? 'active' : '' }}">Messages <span class="bm-pill">{{ $messageCount }}</span></a>
                @endif
                <a href="{{ route('notifications') }}" class="bm-link {{ request()->routeIs('notifications') ? 'active' : '' }}">Notifications <span class="bm-pill">{{ $notificationCount }}</span></a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="bm-logout">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</header>
