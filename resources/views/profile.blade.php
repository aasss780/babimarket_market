<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>BabiMarket - My Account</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>:root{--primary:#FF6F43;--bg:#FBF9F6;--text:#1A1A1A;--text-gray:#7A7A7A;--white:#FFF;--border:#EFEFEF}*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}body{background:var(--bg)}.container{max-width:1200px;margin:34px auto 70px;padding:0 20px;display:grid;grid-template-columns:280px 1fr;gap:30px}.profile-sidebar{background:#fff;padding:30px 20px;border-radius:16px;border:1px solid var(--border)}.content-area{background:#fff;padding:40px;border-radius:16px;border:1px solid var(--border)}label{font-size:13px;font-weight:600;color:#555}input,textarea{width:100%;padding:12px;border:1px solid var(--border);border-radius:8px;margin-top:6px}.btn{padding:12px 25px;background:var(--primary);color:#fff;border:none;border-radius:10px;font-weight:700;cursor:pointer}</style></head><body>
@include('partials.navbar')
<div style="max-width:1200px;margin:0 auto;padding:0 20px;">@include('partials.alerts')</div>
<div class="container">
<div class="profile-sidebar"><div style="text-align:center;margin-bottom:30px;">
    @if($user->avatar)
        <img src="{{ asset('storage/'.$user->avatar) }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin-bottom:10px;">
    @else
        <div style="width:80px;height:80px;border-radius:50%;background:#EFEFEF;color:#777;display:flex;align-items:center;justify-content:center;font-size:30px;font-weight:700;margin:0 auto 10px;">{{ strtoupper(substr($user->name,0,1)) }}</div>
    @endif
    <h3>{{ $user->name }}</h3><p style="font-size:13px;color:#7A7A7A;">{{ $user->email }}</p></div></div>
<div class="content-area"><h2 style="font-size:24px;margin-bottom:20px;">Profile Details</h2>
<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">@csrf
<div style="margin-bottom:15px;"><label>Avatar</label><input type="file" name="avatar" accept="image/*"></div>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:15px;"><div><label>Name</label><input type="text" name="name" value="{{ $user->name }}"></div><div><label>Phone Number</label><input type="text" name="phone" value="{{ $user->phone }}"></div></div>
<div style="margin-bottom:15px;"><label>Address</label><textarea name="address">{{ $user->address }}</textarea></div>
@if($user->role === 'seller')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:15px;"><div><label>Store Name</label><input type="text" name="store_name" value="{{ $user->store_name }}"></div><div><label>Store Description</label><input type="text" name="store_description" value="{{ $user->store_description }}"></div></div>
@endif
<button class="btn" style="margin-top:10px;">Save Changes</button></form>
</div></div></body></html>
