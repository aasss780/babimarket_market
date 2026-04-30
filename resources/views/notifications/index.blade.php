@extends('layouts.app')
@section('content')
<h2>Notifications</h2>
@foreach($notifications as $n)
<div class="card">{{ $n->title }} - {{ $n->message }}</div>
@endforeach
@endsection
