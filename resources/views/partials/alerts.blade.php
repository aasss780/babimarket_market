@if(session('success'))
    <div style="background:#e8f5e9;color:#2e7d32;border:1px solid #c8e6c9;padding:10px 14px;border-radius:10px;margin:14px 0;">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div style="background:#ffebee;color:#c62828;border:1px solid #ffcdd2;padding:10px 14px;border-radius:10px;margin:14px 0;">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
