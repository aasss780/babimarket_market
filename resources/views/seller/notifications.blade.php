@extends('layouts.seller')

@section('content')
    <h2 style="margin-bottom:14px;">Notifications</h2>
    @forelse($notifications as $n)
        <div class="card" style="display:flex;gap:14px;align-items:flex-start;border-left:4px solid {{ $n->is_read ? '#EFEFEF' : '#FF6F43' }};">
            <div style="width:44px;height:44px;border-radius:50%;background:#FFF0EB;color:#FF6F43;display:flex;align-items:center;justify-content:center;">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div style="flex:1;">
                <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;">
                    <h3 style="font-size:16px;margin:0;">{{ $n->title }}</h3>
                    @if(! $n->is_read)
                        <span style="background:#FF6F43;color:#fff;border-radius:999px;padding:2px 8px;font-size:11px;">Unread</span>
                    @endif
                </div>
                <p class="muted" style="margin-top:6px;">{{ $n->message }}</p>
                <div class="muted" style="margin-top:6px;">{{ $n->created_at?->diffForHumans() }}</div>
            </div>
        </div>
    @empty
        <div class="card">
            <h3 style="margin-bottom:6px;">No notifications yet</h3>
            <p class="muted">You are all caught up. New order and message updates will appear here.</p>
        </div>
    @endforelse
@endsection
