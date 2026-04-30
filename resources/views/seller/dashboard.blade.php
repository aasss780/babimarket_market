@extends('layouts.seller')

@section('topbar_action')
    <div style="display:flex;gap:8px;">
        <a href="{{ route('seller.profile.edit') }}" class="btn btn-secondary"><i class="fa-solid fa-user-gear"></i> Edit Profile</a>
        <a href="{{ route('seller.products.create') }}" class="btn"><i class="fa-solid fa-plus"></i> Add Product</a>
    </div>
@endsection

@section('content')
    <div class="card" style="display:flex;align-items:center;gap:14px;">
        @if(auth()->user()->avatar)
            <img src="{{ asset('storage/'.auth()->user()->avatar) }}" style="width:64px;height:64px;border-radius:50%;object-fit:cover;">
        @else
            <div style="width:64px;height:64px;border-radius:50%;background:#EFEFEF;color:#777;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
        @endif
        <div>
            <h3 style="margin:0;">{{ auth()->user()->name }}</h3>
            <p class="muted" style="margin:2px 0;">{{ auth()->user()->email }}</p>
            <p class="muted" style="margin:0;">{{ auth()->user()->store_name ?: 'Seller account' }}</p>
        </div>
    </div>
    <div class="grid" style="margin-bottom:20px;">
        <div class="card"><h3>${{ number_format((float)$withdrawalMetrics['total_earnings'],2) }}</h3><p class="muted">Total Sales (accepted/processing/delivered)</p></div>
        <div class="card"><h3>{{ $orders->count() }}</h3><p class="muted">Total Orders</p></div>
        <div class="card"><h3>{{ $productsCount }}</h3><p class="muted">Active Products</p></div>
        <div class="card" style="display:flex;flex-direction:column;justify-content:space-between;gap:12px;">
            <div>
                <h3 style="font-size:24px;font-weight:800;color:var(--primary);">${{ number_format($withdrawalMetrics['available_balance'], 2) }}</h3>
                <p class="muted" style="margin-top:4px;">Available for withdrawal</p>
                <p class="muted" style="font-size:11px;margin-top:2px;">After 2% platform commission.</p>
            </div>
            <a href="{{ route('seller.withdrawals') }}" class="btn" style="width:100%;justify-content:center;"><i class="fa-solid fa-wallet"></i> Withdraw</a>
        </div>
    </div>
    <div class="card">
        <h2 style="margin-bottom:12px;">Recent Orders</h2>
        @forelse($orders as $order)
            <div style="display:flex;justify-content:space-between;border-bottom:1px solid #EFEFEF;padding:10px 0;">
                <span>Order Item #{{ $order->id }}</span>
                <span>${{ number_format($order->price,2) }} x {{ $order->quantity }}</span>
            </div>
        @empty
            <p class="muted">No orders yet.</p>
        @endforelse
    </div>
@endsection
