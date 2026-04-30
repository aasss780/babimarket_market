<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>BabiMarket - Notifications</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root{--primary:#FF6F43;--primary-light:#FFF0EB;--bg:#FBF9F6;--text:#1A1A1A;--text-gray:#7A7A7A;--white:#FFF;--border:#EFEFEF}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:var(--bg)}
.container{width:90%;max-width:900px;margin:34px auto 70px}
.header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;gap:16px}
.header h1{font-size:32px;font-weight:800}
.header p{font-size:12px;color:var(--text-gray)}
.notif-card{background:#fff;border-radius:16px;padding:18px;display:flex;gap:14px;border:1px solid var(--border);margin-bottom:12px;align-items:flex-start}
.notif-card.unread{background:var(--primary-light);border-color:#FFD5C7}
.notif-icon{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#FFE2D8;color:var(--primary)}
.notif-title{font-size:15px;font-weight:700;margin-bottom:4px;color:var(--text)}
.notif-msg{font-size:13px;color:var(--text-gray);margin-bottom:6px}
.notif-time{font-size:11px;color:#9A9A9A}
.state-pill{margin-left:auto;font-size:11px;padding:4px 10px;border-radius:999px;font-weight:700}
.state-pill.unread{background:#FF6F43;color:#fff}
.state-pill.read{background:#F1F1F1;color:#666}
</style></head><body>
@include('partials.navbar')
<div class="container">
@include('partials.alerts')
<div class="header"><h1>Notifications</h1><p>Unread notifications are marked as read when this page opens.</p></div>
@forelse($notifications as $n)
<div class="notif-card {{ $n->is_read ? '' : 'unread' }}">
    <div class="notif-icon"><i class="fa-solid fa-bell"></i></div>
    <div style="flex:1;">
        <h3 class="notif-title">{{ $n->title }}</h3>
        <p class="notif-msg">{{ $n->message }}</p>
        <div class="notif-time">{{ $n->created_at?->diffForHumans() }}</div>
    </div>
    <span class="state-pill {{ $n->is_read ? 'read' : 'unread' }}">{{ $n->is_read ? 'Read' : 'Unread' }}</span>
</div>
@empty
<div class="notif-card">
    <div class="notif-icon"><i class="fa-regular fa-bell-slash"></i></div>
    <div>
        <h3 class="notif-title">No notifications yet</h3>
        <p class="notif-msg">You will see updates about orders and messages here.</p>
    </div>
</div>
@endforelse
</div></body></html>
