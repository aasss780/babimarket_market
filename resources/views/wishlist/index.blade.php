@extends('layouts.app')
@section('content')
<h2>Wishlist</h2>
@foreach($items as $item)
<div class="card">{{ $item->product->name }}</div>
@endforeach
@endsection
