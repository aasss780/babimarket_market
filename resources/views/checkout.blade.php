<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>BabiMarket - Checkout</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"><style>:root{--primary:#FF6F43;--bg:#FBF9F6;--text:#1A1A1A;--border:#EFEFEF;--danger:#C62828}*{margin:0;padding:0;box-sizing:border-box;font-family:Poppins,sans-serif}body{background:var(--bg);padding:40px 20px}.container{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1.5fr 1fr;gap:40px}@media(max-width:900px){.container{grid-template-columns:1fr}}.card{background:#fff;padding:30px;border-radius:16px;border:1px solid var(--border);margin-bottom:30px}label{font-size:13px;font-weight:600;color:#555}input,select,textarea{width:100%;padding:12px 15px;border:1px solid var(--border);border-radius:8px;font-size:14px;margin-top:6px}input:invalid:not(:placeholder-shown){border-color:#f5a5a5}.checkout-btn{width:100%;padding:15px;background:var(--primary);color:#fff;border:none;border-radius:10px;font-weight:700;cursor:pointer}.pay-box{margin-top:14px;padding:14px;border-radius:10px;background:#F9F9F9;border:1px solid var(--border);font-size:14px;color:#555;line-height:1.5}#checkout-client-errors{color:var(--danger);font-size:13px;margin-bottom:12px;display:none}</style></head><body>
@include('partials.navbar')
<div style="max-width:1200px;margin:0 auto;">@include('partials.alerts')</div>
<div class="container">
<div>
<form method="POST" action="{{ route('checkout.store') }}" id="checkout-form" novalidate>@csrf
<div id="checkout-client-errors" role="alert"></div>
<div class="card"><h2 style="font-size:22px;font-weight:700;margin-bottom:20px;">Shipping Address</h2>
<div style="margin-bottom:20px;"><label>Full Name<input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required></label></div>
<div style="margin-bottom:20px;"><label>Phone<input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required></label></div>
<div style="margin-bottom:20px;"><label>City<input type="text" name="city" value="{{ old('city') }}" required></label></div>
<div><label>Address<textarea name="shipping_address" required>{{ old('shipping_address', auth()->user()->address) }}</textarea></label></div></div>
<div class="card"><h2 style="font-size:22px;font-weight:700;margin-bottom:20px;">Payment Method</h2>
<label><select name="payment_method" id="payment_method"><option value="cash_on_delivery" @selected(old('payment_method')==='cash_on_delivery')>Cash on Delivery</option><option value="credit_card" @selected(old('payment_method')==='credit_card')>Credit Card</option><option value="paypal" @selected(old('payment_method')==='paypal')>PayPal</option></select></label>
<div id="cod_info" class="pay-box" style="display:none;"><strong>Cash on Delivery</strong><p style="margin-top:8px;">Pay when you receive your order.</p></div>
<div id="credit_fields" style="display:none;margin-top:15px;">
    <div class="pay-box" style="margin-bottom:12px;">Enter demo card details only. Nothing is stored except payment method.</div>
    <div style="margin-bottom:10px;"><label>Card Holder Name<input type="text" name="card_holder" id="card_holder" value="{{ old('card_holder') }}" autocomplete="cc-name" minlength="3"></label></div>
    <div style="margin-bottom:10px;"><label>Card Number<input type="text" name="card_number" id="card_number" value="{{ old('card_number') }}" inputmode="numeric" autocomplete="cc-number" placeholder="13–19 digits"></label></div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
        <label>Expiry Date<input type="text" name="card_expiry" id="card_expiry" value="{{ old('card_expiry') }}" placeholder="MM/YY or MM/YYYY" autocomplete="cc-exp"></label>
        <label>CVV<input type="text" name="card_cvv" id="card_cvv" value="{{ old('card_cvv') }}" inputmode="numeric" maxlength="4" autocomplete="cc-csc"></label>
    </div>
</div>
<div id="paypal_fields" style="display:none;margin-top:15px;">
    <div class="pay-box" style="margin-bottom:12px;"><strong>PayPal (demo)</strong><p style="margin-top:8px;">In a real store you would be redirected to PayPal. For this project, enter the PayPal account email you would use.</p></div>
    <label>PayPal email<input type="email" name="paypal_email" id="paypal_email" value="{{ old('paypal_email') }}" placeholder="you@example.com" autocomplete="email"></label>
</div>
</div>
<button class="checkout-btn" type="submit">Place Order Securely</button>
</form></div>
<div class="card"><h2 style="font-size:22px;font-weight:700;margin-bottom:20px;">Order Summary</h2>
@php($total = 0)
@foreach($items as $item)
    @php($line = $item->quantity * $item->product->price)
    @php($total += $line)
    <div style="display:flex;justify-content:space-between;margin-bottom:12px;"><span>{{ $item->product->name }} x{{ $item->quantity }}</span><strong>${{ number_format($line,2) }}</strong></div>
@endforeach
<hr style="margin:16px 0;border:none;border-top:1px solid #EFEFEF">
<div style="display:flex;justify-content:space-between;font-size:20px;font-weight:800;"><span>Total</span><span>${{ number_format($total,2) }}</span></div>
</div>
</div>
<script>
(function(){
    var pm = document.getElementById('payment_method');
    var cf = document.getElementById('credit_fields');
    var pf = document.getElementById('paypal_fields');
    var cod = document.getElementById('cod_info');
    var form = document.getElementById('checkout-form');
    var errBox = document.getElementById('checkout-client-errors');

    function togglePayment(){
        var v = pm.value;
        cf.style.display = v === 'credit_card' ? 'block' : 'none';
        pf.style.display = v === 'paypal' ? 'block' : 'none';
        cod.style.display = v === 'cash_on_delivery' ? 'block' : 'none';
    }
    pm.addEventListener('change', togglePayment);
    togglePayment();

    function digitsOnly(s){ return String(s||'').replace(/\D/g,''); }

    function validateExpiryClient(exp){
        var e = String(exp||'').replace(/\s/g,'').toUpperCase();
        if(!e) return 'Enter expiry (MM/YY or MM/YYYY).';
        var m = e.match(/^(0[1-9]|1[0-2])\/(\d{2}|\d{4})$/);
        if(!m) return 'Invalid expiry format. Use MM/YY or MM/YYYY (month 01–12).';
        var month = parseInt(m[1],10);
        var yPart = m[2];
        var year = yPart.length === 2 ? (2000 + parseInt(yPart,10)) : parseInt(yPart,10);
        var now = new Date();
        var cy = now.getFullYear();
        var cm = now.getMonth()+1;
        if(year < cy || (year === cy && month < cm)) return 'This card has expired. Use a future date.';
        return null;
    }

    function clientValidate(){
        errBox.style.display = 'none';
        errBox.textContent = '';
        var v = pm.value;
        if(v === 'credit_card'){
            var holder = (document.getElementById('card_holder').value||'').trim();
            if(holder.length < 3){ errBox.textContent = 'Card holder must be at least 3 characters.'; errBox.style.display='block'; return false; }
            var num = digitsOnly(document.getElementById('card_number').value);
            if(num.length < 13 || num.length > 19){ errBox.textContent = 'Card number must be 13–19 digits (spaces allowed).'; errBox.style.display='block'; return false; }
            var exMsg = validateExpiryClient(document.getElementById('card_expiry').value);
            if(exMsg){ errBox.textContent = exMsg; errBox.style.display='block'; return false; }
            var cvv = digitsOnly(document.getElementById('card_cvv').value);
            if(!/^\d{3,4}$/.test(cvv)){ errBox.textContent = 'CVV must be 3 or 4 digits.'; errBox.style.display='block'; return false; }
        }
        if(v === 'paypal'){
            var em = (document.getElementById('paypal_email').value||'').trim();
            if(!em){ errBox.textContent = 'Please enter your PayPal email.'; errBox.style.display='block'; return false; }
            if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em)){ errBox.textContent = 'Please enter a valid email address.'; errBox.style.display='block'; return false; }
        }
        return true;
    }

    form.addEventListener('submit', function(ev){
        if(!clientValidate()) ev.preventDefault();
    });
})();
</script>
</body></html>
