@extends('layouts.app')
@section('content')
<h2>Cart</h2>
@forelse($items as $item)
    <div class="card">
        <div style="display:grid;grid-template-columns:74px 1fr auto;gap:12px;align-items:center;">
            <div style="width:74px;height:74px;border-radius:10px;overflow:hidden;background:#F0F0F0;display:flex;align-items:center;justify-content:center;">
                @if($item->product->primary_image_url)
                    <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <i class="fa-regular fa-image" style="color:#BDBDBD;"></i>
                @endif
            </div>
            <div>
                <strong>{{ $item->product->name }}</strong>
                <div class="muted">Qty: {{ $item->quantity }} · ${{ number_format($item->product->price, 2) }}</div>
            </div>
            <div>${{ number_format($item->product->price * $item->quantity, 2) }}</div>
        </div>
        <form method="POST" action="{{ route('cart.destroy', $item->id) }}">@csrf <button class="btn">Remove</button></form>
    </div>
@empty
    <div class="card">
        <p>Your cart is empty.</p>
        <a class="btn" href="{{ route('products.index') }}">Browse Products</a>
    </div>
@endforelse
@if($items->count())
    <a class="btn" href="{{ route('checkout.index') }}">Proceed to Checkout</a>
@endif
@endsection
