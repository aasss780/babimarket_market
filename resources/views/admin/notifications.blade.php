@extends('layouts.admin')

@section('page_title', 'Notifications')

@section('content')
    <p class="muted" style="margin-bottom:18px;">Alerts for your admin account.</p>
    <div class="card" style="margin:0;padding:0;overflow:hidden;">
        @forelse($notifications as $n)
            <div style="padding:16px 20px;border-bottom:1px solid var(--border-color);">
                <div style="font-weight:700;font-size:15px;">{{ $n->title }}</div>
                <div class="muted" style="margin-top:6px;font-size:14px;">{{ $n->message }}</div>
                <div class="muted" style="margin-top:8px;font-size:12px;">{{ $n->created_at?->format('M j, Y g:i a') }}</div>
            </div>
        @empty
            <div class="muted" style="padding:32px;text-align:center;">No notifications yet.</div>
        @endforelse
    </div>
@endsection
