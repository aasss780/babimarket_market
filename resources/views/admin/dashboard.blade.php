@extends('layouts.admin')

@section('page_title', 'Dashboard overview')

@section('content')
    <p class="muted" style="margin-bottom:20px;">Summary of marketplace activity.</p>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:18px;">
        <div class="card" style="margin:0;"><h3 style="font-size:28px;font-weight:800;color:var(--primary);">{{ $stats['total_users'] }}</h3><p class="muted" style="margin-top:6px;">Total users</p></div>
        <div class="card" style="margin:0;"><h3 style="font-size:28px;font-weight:800;color:var(--primary);">{{ $stats['total_sellers'] }}</h3><p class="muted" style="margin-top:6px;">Sellers</p></div>
        <div class="card" style="margin:0;"><h3 style="font-size:28px;font-weight:800;color:var(--primary);">{{ $stats['total_customers'] }}</h3><p class="muted" style="margin-top:6px;">Customers</p></div>
        <div class="card" style="margin:0;"><h3 style="font-size:28px;font-weight:800;color:var(--primary);">{{ $stats['total_products'] }}</h3><p class="muted" style="margin-top:6px;">Products</p></div>
        <div class="card" style="margin:0;"><h3 style="font-size:28px;font-weight:800;color:var(--primary);">{{ $stats['total_orders'] }}</h3><p class="muted" style="margin-top:6px;">Orders</p></div>
        <div class="card" style="margin:0;"><h3 style="font-size:28px;font-weight:800;color:var(--primary);">${{ number_format($stats['total_revenue'], 2) }}</h3><p class="muted" style="margin-top:6px;">Platform commission (2%)</p></div>
    </div>
@endsection
