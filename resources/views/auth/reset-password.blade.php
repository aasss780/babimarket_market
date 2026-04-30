<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BabiMarket - Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary:#FF6F43; --bg:#FBF9F6; --white:#FFFFFF; --text-dark:#1A1A1A; --text-gray:#7A7A7A; --border:#EFEFEF; }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body { background-color:var(--bg); color:var(--text-dark); display:flex; justify-content:center; align-items:center; min-height:100vh; padding:40px 16px; }
        .login-card { background-color:var(--white); width:100%; max-width:450px; padding:40px; border-radius:20px; box-shadow:0 15px 35px rgba(0,0,0,0.03); text-align:center; }
        .logo { display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:25px; }
        .logo-icon { background:#4CAF50; color:white; width:32px; height:32px; display:flex; justify-content:center; align-items:center; border-radius:8px; font-size:18px; font-weight:bold; }
        .logo-text { font-size:20px; font-weight:800; color:#1E3A34; }
        .welcome-text h1 { font-size:28px; font-weight:800; margin-bottom:10px; color:var(--text-dark); }
        .welcome-text p { font-size:14px; color:var(--text-gray); margin-bottom:20px; }
        .demo-note { font-size:11px; color:var(--text-gray); background:#F9F9F9; border:1px solid var(--border); border-radius:10px; padding:10px 12px; margin-bottom:22px; text-align:left; line-height:1.45; }
        .form-group { margin-bottom:18px; text-align:left; }
        label { font-size:13px; font-weight:600; color:#444; margin-bottom:8px; display:block; }
        input { width:100%; padding:14px; border:1px solid var(--border); border-radius:10px; background-color:#F9F9F9; font-size:14px; transition:0.3s; }
        input:focus { outline:none; border-color:var(--primary); background-color:white; }
        input[readonly] { background:#EFEFEF; color:var(--text-gray); }
        .btn-primary { width:100%; padding:14px; background-color:var(--primary); color:white; border:none; border-radius:10px; font-size:15px; font-weight:700; cursor:pointer; transition:0.3s; margin-top:8px; margin-bottom:16px; }
        .btn-primary:hover { background-color:#E65A2B; }
        .footer-text { font-size:13px; color:var(--text-dark); font-weight:500; }
        .footer-text a { color:var(--primary); text-decoration:none; font-weight:700; }
        .error-box { text-align:left; background:#ffefef; color:#b12020; border:1px solid #ffc9c9; padding:10px; border-radius:10px; margin-bottom:14px; font-size:12px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo"><div class="logo-icon">B</div><span class="logo-text">BabiMarket</span></div>
        <div class="welcome-text">
            <h1>Set new password</h1>
            <p>Choose a new password for your account.</p>
        </div>
        <div class="demo-note"><i class="fa-solid fa-circle-info" style="color:var(--primary);"></i> <strong>Demo:</strong> No verification link—anyone with this page URL can reset. Not for production.</div>
        @if($errors->any())
            <div class="error-box">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif
        <form action="{{ route('password.reset.post') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="form-group">
                <label for="email_display">Email</label>
                <input type="email" id="email_display" value="{{ $email }}" readonly autocomplete="username">
            </div>
            <div class="form-group">
                <label for="password">New password</label>
                <input type="password" id="password" name="password" placeholder="At least 6 characters" required autocomplete="new-password" minlength="6">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat password" required autocomplete="new-password" minlength="6">
            </div>
            <button type="submit" class="btn-primary">Update password</button>
        </form>
        <div class="footer-text"><a href="{{ route('login') }}"><i class="fa-solid fa-arrow-left"></i> Back to login</a></div>
    </div>
</body>
</html>
