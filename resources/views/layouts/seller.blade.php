<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Seller Dashboard' }} - BabiMarket</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary:#FF6F43; --bg-color:#FBF9F6; --sidebar-bg:#FFFFFF; --text-dark:#1A1A1A; --text-gray:#7A7A7A; --white:#FFFFFF; --border-color:#EFEFEF; }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background-color:var(--bg-color); color:var(--text-dark); display:flex; min-height:100vh; }
        .sidebar { width:260px; background:var(--sidebar-bg); border-right:1px solid var(--border-color); position:fixed; height:100vh; }
        .logo-area { padding:25px 20px; display:flex; align-items:center; gap:10px; font-size:20px; font-weight:800; color:#1E3A34; border-bottom:1px solid var(--border-color); }
        .logo-icon { background:#4CAF50; color:white; width:32px; height:32px; display:flex; justify-content:center; align-items:center; border-radius:8px; font-size:18px; }
        .nav-menu { padding:20px 15px; display:flex; flex-direction:column; gap:8px; }
        .nav-item { display:flex; align-items:center; gap:15px; padding:12px 15px; border-radius:12px; font-size:14px; font-weight:500; color:var(--text-gray); text-decoration:none; }
        .nav-item.active, .nav-item:hover { background:var(--primary); color:white; }
        button.nav-item { width:100%; border:none; background:transparent; cursor:pointer; font:inherit; text-align:left; color:var(--text-gray); }
        button.nav-item:hover, button.nav-item:focus-visible { background:var(--primary); color:#fff; outline:none; }
        .main-content { flex:1; margin-left:260px; width:calc(100% - 260px); }
        .top-bar { background:var(--white); height:80px; padding:0 30px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border-color); }
        .dashboard-body { padding:30px; }
        .card { background:var(--white); border-radius:16px; padding:20px; box-shadow:0 5px 20px rgba(0,0,0,0.02); margin-bottom:20px; }
        .btn { background:var(--primary); color:white; border:none; padding:10px 16px; border-radius:10px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
        .btn-secondary { background:#fff; color:var(--text-dark); border:1px solid var(--border-color); }
        .btn-danger { background:#d84343; }
        .grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:16px; }
        .muted { color:var(--text-gray); font-size:13px; }
        input, textarea, select { width:100%; padding:12px; border:1px solid var(--border-color); border-radius:10px; background:#F9F9F9; font-size:14px; }
        label { font-size:13px; font-weight:600; color:#444; margin-bottom:8px; display:block; }
        .alert-success { background:#e8f5e9; border:1px solid #c8e6c9; color:#2e7d32; padding:10px 14px; border-radius:10px; margin-bottom:14px; }
        .alert-error { background:#ffebee; border:1px solid #ffcdd2; color:#c62828; padding:10px 14px; border-radius:10px; margin-bottom:14px; }
    </style>
</head>
<body>
    @php
        $sellerId = auth()->id();
        $sellerMessageUnread = \App\Models\Message::where('receiver_id', $sellerId)->where('is_read', false)->whereNotNull('product_id')->count();
        $sellerOrderPending = \App\Models\OrderItem::where('seller_id', $sellerId)->whereHas('order', fn($q) => $q->where('status', 'pending'))->count();
        $sellerNotificationUnread = \App\Models\Notification::where('user_id', $sellerId)->where('is_read', false)->count();
    @endphp
    <aside class="sidebar">
        <div class="logo-area"><div class="logo-icon">B</div>BabiMarket</div>
        <div class="nav-menu">
            <a href="{{ route('seller.dashboard') }}" class="nav-item {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            <a href="{{ route('seller.products.index') }}" class="nav-item {{ request()->routeIs('seller.products.*') ? 'active' : '' }}"><i class="fa-solid fa-box"></i> Products</a>
            <a href="{{ route('seller.products.create') }}" class="nav-item {{ request()->routeIs('seller.products.create') ? 'active' : '' }}"><i class="fa-solid fa-plus"></i> Add Product</a>
            <a href="{{ route('seller.orders') }}" class="nav-item {{ request()->routeIs('seller.orders') ? 'active' : '' }}"><i class="fa-solid fa-cart-shopping"></i> Orders <span style="margin-left:auto;background:#FF6F43;color:#fff;border-radius:999px;padding:0 8px;font-size:11px;">{{ $sellerOrderPending }}</span></a>
            <a href="{{ route('seller.messages') }}" class="nav-item {{ request()->routeIs('seller.messages') ? 'active' : '' }}"><i class="fa-solid fa-envelope"></i> Messages <span style="margin-left:auto;background:#FF6F43;color:#fff;border-radius:999px;padding:0 8px;font-size:11px;">{{ $sellerMessageUnread }}</span></a>
            <a href="{{ route('seller.notifications') }}" class="nav-item {{ request()->routeIs('seller.notifications') ? 'active' : '' }}"><i class="fa-solid fa-bell"></i> Notifications <span style="margin-left:auto;background:#FF6F43;color:#fff;border-radius:999px;padding:0 8px;font-size:11px;">{{ $sellerNotificationUnread }}</span></a>
            <a href="{{ route('seller.withdrawals') }}" class="nav-item {{ request()->routeIs('seller.withdrawals*') ? 'active' : '' }}"><i class="fa-solid fa-wallet"></i> Withdrawals</a>
            <a href="{{ route('seller.profile.edit') }}" class="nav-item {{ request()->routeIs('seller.profile.*') ? 'active' : '' }}"><i class="fa-solid fa-user-gear"></i> Edit Profile</a>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:4px;">@csrf<button type="submit" class="nav-item"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button></form>
        </div>
    </aside>
    <main class="main-content">
        <header class="top-bar">
            <div style="display:flex;align-items:center;gap:10px;">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/'.auth()->user()->avatar) }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                @else
                    <div style="width:36px;height:36px;border-radius:50%;background:#EFEFEF;color:#777;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                @endif
                <span>{{ auth()->user()->name }}</span>
            </div>
            @yield('topbar_action')
        </header>
        <div class="dashboard-body">
            @if(session('success'))<div class="alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
            @yield('content')
        </div>
    </main>
    @stack('scripts')
</body>
</html>
