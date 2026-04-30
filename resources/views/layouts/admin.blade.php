<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} - BabiMarket</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary:#FF6F43; --bg-color:#FBF9F6; --sidebar-bg:#1E3A34; --text-dark:#1A1A1A; --text-gray:#7A7A7A; --white:#FFFFFF; --border-color:#EFEFEF; }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background-color:var(--bg-color); color:var(--text-dark); display:flex; min-height:100vh; overflow-x:hidden; }
        .sidebar { width:260px; background:var(--sidebar-bg); position:fixed; height:100vh; color:white; z-index:100; }
        .logo-area { padding:25px 20px; font-size:18px; font-weight:800; border-bottom:1px solid rgba(255,255,255,0.1); display:flex; align-items:center; gap:10px; }
        .logo-icon { background:#4CAF50; color:white; width:32px; height:32px; display:flex; justify-content:center; align-items:center; border-radius:8px; font-size:16px; }
        .nav-menu { padding:20px 15px; display:flex; flex-direction:column; gap:6px; }
        .nav-item { display:flex; align-items:center; gap:12px; padding:12px 14px; border-radius:12px; font-size:14px; color:rgba(255,255,255,0.75); text-decoration:none; font-weight:500; border:none; background:transparent; width:100%; text-align:left; cursor:pointer; }
        .nav-item:hover, .nav-item.active { background:var(--primary); color:white; }
        button.nav-item { font:inherit; }
        button.nav-item:hover, button.nav-item:focus-visible { background:var(--primary); color:#fff; outline:none; }
        .badge { margin-left:auto; background:#FF6F43; color:#fff; border-radius:999px; padding:0 8px; font-size:11px; font-weight:700; min-width:20px; text-align:center; }
        .main-content { flex:1; margin-left:260px; width:calc(100% - 260px); min-height:100vh; }
        .top-bar { background:var(--white); min-height:72px; padding:12px 28px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--border-color); flex-wrap:wrap; gap:12px; }
        .top-bar h1 { font-size:20px; font-weight:800; color:var(--text-dark); }
        .dashboard-body { padding:28px; }
        .card { background:var(--white); border-radius:16px; padding:22px 24px; border:1px solid var(--border-color); box-shadow:0 5px 20px rgba(0,0,0,0.03); margin-bottom:20px; }
        .btn { background:var(--primary); color:white; border:none; padding:10px 16px; border-radius:10px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-size:14px; }
        .btn-sm { padding:8px 12px; font-size:13px; border-radius:8px; }
        .btn-secondary { background:#fff; color:var(--text-dark); border:1px solid var(--border-color); }
        .btn-danger { background:#c62828; color:#fff; }
        .muted { color:var(--text-gray); font-size:13px; }
        .table-wrap { overflow-x:auto; border-radius:14px; border:1px solid var(--border-color); background:var(--white); }
        table { width:100%; border-collapse:collapse; font-size:14px; }
        th { text-align:left; padding:14px 16px; background:#F9F9F9; color:#555; font-weight:600; border-bottom:1px solid var(--border-color); }
        td { padding:14px 16px; border-bottom:1px solid var(--border-color); vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        .alert-success { background:#e8f5e9; border:1px solid #c8e6c9; color:#2e7d32; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:14px; }
        .alert-error { background:#ffebee; border:1px solid #ffcdd2; color:#c62828; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:14px; }
        input, textarea, select { font-family:inherit; font-size:14px; border:1px solid var(--border-color); border-radius:10px; padding:10px 12px; }
        @media (max-width:900px) {
            .sidebar { width:100%; height:auto; position:relative; }
            .main-content { margin-left:0; width:100%; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @php
        $adminId = auth()->id();
        $adminContactUnread = \App\Models\Message::where('receiver_id', $adminId)->whereNull('product_id')->where('is_read', false)->count();
        $adminNotifUnread = \App\Models\Notification::where('user_id', $adminId)->where('is_read', false)->count();
        $adminPendingWithdrawals = \App\Models\Withdrawal::where('status', \App\Models\Withdrawal::STATUS_PENDING)
            ->whereHas('seller', fn ($q) => $q->where('role', 'seller'))
            ->count();
    @endphp
    <aside class="sidebar">
        <div class="logo-area"><div class="logo-icon">B</div> Admin Panel</div>
        <nav class="nav-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> Overview</a>
            <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Users</a>
            <a href="{{ route('admin.products') }}" class="nav-item {{ request()->routeIs('admin.products') ? 'active' : '' }}"><i class="fa-solid fa-box"></i> Products</a>
            <a href="{{ route('admin.orders') }}" class="nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}"><i class="fa-solid fa-receipt"></i> Orders</a>
            <a href="{{ route('admin.categories') }}" class="nav-item {{ request()->routeIs('admin.categories') ? 'active' : '' }}"><i class="fa-solid fa-list"></i> Categories</a>
            <a href="{{ route('admin.messages') }}" class="nav-item {{ request()->routeIs('admin.messages') ? 'active' : '' }}"><i class="fa-solid fa-envelope"></i> Contact Messages @if($adminContactUnread)<span class="badge">{{ $adminContactUnread }}</span>@endif</a>
            <a href="{{ route('admin.notifications') }}" class="nav-item {{ request()->routeIs('admin.notifications') ? 'active' : '' }}"><i class="fa-solid fa-bell"></i> Notifications @if($adminNotifUnread)<span class="badge">{{ $adminNotifUnread }}</span>@endif</a>
            <a href="{{ route('admin.withdrawals') }}" class="nav-item {{ request()->routeIs('admin.withdrawals*') ? 'active' : '' }}"><i class="fa-solid fa-wallet"></i> Withdrawals @if($adminPendingWithdrawals)<span class="badge">{{ $adminPendingWithdrawals }}</span>@endif</a>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:8px;">@csrf<button type="submit" class="nav-item"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button></form>
        </nav>
    </aside>
    <main class="main-content">
        <header class="top-bar">
            <h1>@yield('page_title', 'Admin')</h1>
            <div style="display:flex;align-items:center;gap:10px;color:var(--text-gray);font-size:14px;">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                @else
                    <div style="width:36px;height:36px;border-radius:50%;background:#EFEFEF;color:#777;display:flex;align-items:center;justify-content:center;font-weight:700;">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                @endif
                <span style="color:var(--text-dark);font-weight:600;">{{ auth()->user()->name }}</span>
            </div>
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
