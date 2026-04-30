@extends('layouts.app')
@section('content')
<div class="card">
    <h2>Checkout</h2>
    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <label>Name<input name="shipping_name" required></label>
        <label>Phone<input name="shipping_phone" required></label>
        <label>Address<textarea name="shipping_address" required></textarea></label>
        <label>Payment<select name="payment_method"><option>cash</option><option>card</option></select></label>
        <button class="btn">Place Order</button>
    </form>
</div>
@endsection
