<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BabiMarket' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body{font-family:Poppins,sans-serif;background:#FBF9F6;margin:0;color:#1A1A1A}
        .container{width:90%;max-width:1200px;margin:0 auto}
        .card{background:#fff;border:1px solid #eee;border-radius:14px;padding:20px;margin:20px 0}
        .btn{background:#FF6F43;color:#fff;border:none;border-radius:8px;padding:10px 14px;cursor:pointer}
        input,select,textarea{width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;margin-top:6px}
        a{text-decoration:none;color:inherit}
    </style>
</head>
<body>
@include('partials.navbar')
<div class="container">
    @include('partials.alerts')
    @yield('content')
</div>
</body>
</html>
