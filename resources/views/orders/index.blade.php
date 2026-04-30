@extends('layouts.app')
@section('content')
<h2>Order History</h2>
@foreach($orders as $order)
<div class="card">
    <strong>#{{ $order->id }}</strong> - ${{ $order->total_price }} - <strong>{{ ucfirst($order->status) }}</strong>
    <div style="font-size:12px;color:#777;margin-top:6px;">{{ $order->shipping_name }} | {{ $order->shipping_phone }} | {{ $order->shipping_address }}</div>
</div>
@endforeach
@endsection
