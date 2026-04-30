@extends('layouts.seller')

@section('topbar_action')
    <a href="{{ route('seller.dashboard') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
@endsection

@section('content')
    <div class="card">
        <h2 style="margin-bottom:14px;">Edit Profile</h2>
        <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
            @csrf
            <div style="display:flex;gap:16px;align-items:center;margin-bottom:16px;">
                @if($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" style="width:76px;height:76px;border-radius:50%;object-fit:cover;border:2px solid #EFEFEF;">
                @else
                    <div style="width:76px;height:76px;border-radius:50%;background:#EFEFEF;color:#777;display:flex;align-items:center;justify-content:center;font-size:30px;font-weight:700;">{{ strtoupper(substr($user->name,0,1)) }}</div>
                @endif
                <div style="flex:1;">
                    <label style="margin-bottom:6px;">Avatar</label>
                    <input type="file" name="avatar" accept="image/*">
                    <div class="muted" style="margin-top:4px;">JPG, PNG, WEBP up to 2MB.</div>
                </div>
            </div>

            <div class="grid">
                <label>Name<input type="text" name="name" value="{{ old('name', $user->name) }}" required></label>
                <label>Email<input type="email" name="email" value="{{ old('email', $user->email) }}" required></label>
                <label>Phone<input type="text" name="phone" value="{{ old('phone', $user->phone) }}"></label>
                <label>Store Name<input type="text" name="store_name" value="{{ old('store_name', $user->store_name) }}"></label>
            </div>
            <label style="margin-top:10px;">Address<textarea name="address">{{ old('address', $user->address) }}</textarea></label>
            <label style="margin-top:10px;">Store Description<textarea name="store_description">{{ old('store_description', $user->store_description) }}</textarea></label>
            <button class="btn" type="submit" style="margin-top:12px;">Save Changes</button>
        </form>
    </div>
@endsection
