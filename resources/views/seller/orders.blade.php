@extends('layouts.seller')

@section('content')
    <h2 style="margin-bottom:14px;">Seller Orders</h2>
    @forelse($orders as $order)
        <div class="card" style="display:grid;grid-template-columns:90px 1fr auto;gap:14px;align-items:start;">
            <div style="width:90px;height:90px;border-radius:12px;overflow:hidden;background:#F2F2F2;border:1px solid #EFEFEF;display:flex;align-items:center;justify-content:center;">
                @if($order->product && $order->product->primary_image_url)
                    <img src="{{ $order->product->primary_image_url }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <i class="fa-regular fa-image" style="color:#B0B0B0;font-size:22px;"></i>
                @endif
            </div>
            <div>
                @php
                    $gross = (float) $order->price * (int) $order->quantity;
                    $commission = $gross * \App\Support\SellerWithdrawalMetrics::PLATFORM_COMMISSION_RATE;
                    $net = $gross - $commission;
                @endphp
                <div><strong>{{ $order->product->name ?? 'Product' }}</strong></div>
                <div class="muted">Order #{{ $order->order_id }} | Qty: {{ $order->quantity }} | Price: ${{ number_format($order->price,2) }}</div>
                <div class="muted">Gross: ${{ number_format($gross,2) }} | Platform fee (2%): ${{ number_format($commission,2) }} | Net earning: <strong>${{ number_format($net,2) }}</strong></div>
                <div class="muted" style="margin-top:4px;">Customer: {{ $order->order->shipping_name }} | {{ $order->order->shipping_phone }}</div>
                <div class="muted">Delivery: {{ $order->order->shipping_address }}</div>
                @if($order->order->notes)<div class="muted">Notes: {{ $order->order->notes }}</div>@endif
                <div style="margin-top:6px;">Status: <strong>{{ ucfirst($order->order->status) }}</strong></div>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                @if($order->order->status === 'pending')
                    <form method="POST" action="{{ route('seller.orders.status', $order->id) }}">
                        @csrf
                        <input type="hidden" name="status" value="processing">
                        <button class="btn" type="submit">Accept</button>
                    </form>
                    <form method="POST" action="{{ route('seller.orders.status', $order->id) }}">
                        @csrf
                        <input type="hidden" name="status" value="cancelled">
                        <button class="btn btn-danger" type="submit">Reject</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="card"><p class="muted">No orders yet.</p></div>
    @endforelse
@endsection
