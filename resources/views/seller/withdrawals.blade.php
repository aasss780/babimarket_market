@extends('layouts.seller')

@section('topbar_action')
    <a href="{{ route('seller.dashboard') }}" class="btn btn-secondary"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
@endsection

@section('content')
    <h2 style="margin-bottom:8px;">Withdrawals</h2>
    <p class="muted" style="margin-bottom:20px;">Request payouts from your available balance. Earnings include only accepted/processing/delivered sales. Pending withdrawals reduce available balance until approval/rejection.</p>

    <div class="grid" style="margin-bottom:24px;">
        <div class="card">
            <h3 style="font-size:26px;font-weight:800;color:var(--primary);">${{ number_format($metrics['available_balance'], 2) }}</h3>
            <p class="muted" style="margin-top:6px;">Available balance</p>
        </div>
        <div class="card">
            <h3 style="font-size:26px;font-weight:800;">${{ number_format($metrics['total_earnings'], 2) }}</h3>
            <p class="muted" style="margin-top:6px;">Total earnings</p>
            <p class="muted" style="font-size:11px;margin-top:4px;">Only accepted/processing/delivered orders count.</p>
            <p class="muted" style="font-size:11px;margin-top:4px;">Platform commission: 2% (already deducted).</p>
        </div>
        <div class="card">
            <h3 style="font-size:26px;font-weight:800;">${{ number_format($metrics['pending_withdrawals'], 2) }}</h3>
            <p class="muted" style="margin-top:6px;">Pending withdrawals</p>
        </div>
        <div class="card">
            <h3 style="font-size:26px;font-weight:800;">${{ number_format($metrics['approved_withdrawals'], 2) }}</h3>
            <p class="muted" style="margin-top:6px;">Approved withdrawals</p>
        </div>
    </div>

    <div class="card" style="margin-bottom:24px;">
        <h3 style="margin-bottom:16px;font-size:18px;">Request withdrawal</h3>
        @if($metrics['available_balance'] < 1)
            <p class="muted">You need at least $1.00 available balance to request a withdrawal.</p>
        @else
            <form method="POST" action="{{ route('seller.withdrawals.store') }}" id="withdrawal-form" style="max-width:640px;">
                @csrf
                <label>Amount (max ${{ number_format($metrics['available_balance'], 2) }})</label>
                <input type="number" name="amount" step="0.01" min="1" max="{{ $metrics['available_balance'] }}" value="{{ old('amount') }}" required>
                <label style="margin-top:14px;">Payment method</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="">Select…</option>
                    <option value="bank_transfer" @selected(old('payment_method')==='bank_transfer')>Bank Transfer</option>
                    <option value="paypal" @selected(old('payment_method')==='paypal')>PayPal</option>
                    <option value="cash_pickup" @selected(old('payment_method')==='cash_pickup')>Cash Office Pickup</option>
                    <option value="local_transfer" @selected(old('payment_method')==='local_transfer')>Wish Money / OMT / Local Transfer</option>
                    <option value="other" @selected(old('payment_method')==='other')>Other</option>
                </select>

                <div id="method-bank" style="display:none;margin-top:12px;">
                    <div class="grid" style="grid-template-columns:1fr 1fr;gap:12px;">
                        <div><label>Bank name</label><input type="text" name="bank_name" value="{{ old('bank_name') }}"></div>
                        <div><label>Account holder name</label><input type="text" name="account_holder_name" value="{{ old('account_holder_name') }}"></div>
                        <div><label>Account number</label><input type="text" name="account_number" value="{{ old('account_number') }}"></div>
                        <div><label>IBAN (optional)</label><input type="text" name="iban" value="{{ old('iban') }}"></div>
                        <div><label>Phone (optional)</label><input type="text" name="bank_phone" value="{{ old('bank_phone') }}"></div>
                    </div>
                </div>

                <div id="method-paypal" style="display:none;margin-top:12px;">
                    <label>PayPal email</label>
                    <input type="email" name="paypal_email" value="{{ old('paypal_email') }}">
                </div>

                <div id="method-cash" style="display:none;margin-top:12px;">
                    <div class="grid" style="grid-template-columns:1fr 1fr;gap:12px;">
                        <div><label>Full name</label><input type="text" name="cash_full_name" value="{{ old('cash_full_name') }}"></div>
                        <div><label>Phone</label><input type="text" name="cash_phone" value="{{ old('cash_phone') }}"></div>
                    </div>
                    <div class="grid" style="grid-template-columns:1fr 1fr;gap:12px;margin-top:12px;">
                        <div><label>Pickup branch</label><input type="text" name="pickup_branch" value="{{ old('pickup_branch') }}"></div>
                        <div><label>Pickup note</label><input type="text" name="pickup_note" value="{{ old('pickup_note') }}"></div>
                    </div>
                    <p class="muted" style="margin-top:6px;">Provide pickup branch or pickup note.</p>
                </div>

                <div id="method-other" style="display:none;margin-top:12px;">
                    <label>Payment details</label>
                    <textarea name="payment_details" rows="4" maxlength="1000" placeholder="Enter custom payout details">{{ old('payment_details') }}</textarea>
                </div>
                <div id="method-local" style="display:none;margin-top:12px;">
                    <div class="grid" style="grid-template-columns:1fr 1fr;gap:12px;">
                        <div><label>Full name</label><input type="text" name="local_full_name" value="{{ old('local_full_name') }}"></div>
                        <div><label>Phone</label><input type="text" name="local_phone" value="{{ old('local_phone') }}"></div>
                    </div>
                    <div style="margin-top:12px;"><label>Transfer service name</label><input type="text" name="transfer_service_name" value="{{ old('transfer_service_name') }}" placeholder="Wish Money / OMT / Local Transfer"></div>
                    <div style="margin-top:12px;"><label>Notes (optional)</label><textarea name="notes" rows="3" maxlength="1000">{{ old('notes') }}</textarea></div>
                </div>
                <button type="submit" class="btn" style="margin-top:16px;">Submit request</button>
            </form>
        @endif
    </div>

    <div class="card">
        <h3 style="margin-bottom:16px;font-size:18px;">Withdrawal history</h3>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <thead>
                    <tr style="text-align:left;border-bottom:1px solid var(--border-color);">
                        <th style="padding:10px 8px;">Date</th>
                        <th style="padding:10px 8px;">Amount</th>
                        <th style="padding:10px 8px;">Method</th>
                        <th style="padding:10px 8px;">Details</th>
                        <th style="padding:10px 8px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawals as $w)
                        @php
                            $methodLabel = match ($w->payment_method) {
                                'bank_transfer' => 'Bank Transfer',
                                'paypal' => 'PayPal',
                                'cash_pickup' => 'Cash Office Pickup',
                                'local_transfer' => 'Wish Money / OMT / Local Transfer',
                                'other' => 'Other',
                                default => $w->payment_method,
                            };
                            $decoded = json_decode((string) $w->payment_details, true);
                            if (! is_array($decoded)) {
                                $decoded = ['payment_details' => $w->payment_details];
                            }
                            $detailText = collect($decoded)
                                ->filter(fn ($v) => filled($v))
                                ->map(fn ($v, $k) => ucwords(str_replace('_', ' ', (string) $k)).': '.$v)
                                ->implode(' | ');
                        @endphp
                        <tr style="border-bottom:1px solid var(--border-color);">
                            <td style="padding:10px 8px;" class="muted">{{ $w->created_at?->format('M j, Y g:i a') }}</td>
                            <td style="padding:10px 8px;"><strong>${{ number_format((float)$w->amount, 2) }}</strong></td>
                            <td style="padding:10px 8px;">{{ $methodLabel }}</td>
                            <td style="padding:10px 8px;max-width:340px;" class="muted">{{ \Illuminate\Support\Str::limit($detailText, 120) }}</td>
                            <td style="padding:10px 8px;">
                                <span style="padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;text-transform:capitalize;background:{{ $w->status==='approved' ? '#E8F5E9' : ($w->status==='rejected' ? '#FFEBEE' : '#FFF3E0') }};color:{{ $w->status==='approved' ? '#2E7D32' : ($w->status==='rejected' ? '#C62828' : '#E65100') }};">{{ $w->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="muted" style="padding:20px;">No withdrawal requests yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(() => {
    const select = document.getElementById('payment_method');
    if (!select) return;
    const sections = {
        bank_transfer: document.getElementById('method-bank'),
        paypal: document.getElementById('method-paypal'),
        cash_pickup: document.getElementById('method-cash'),
        local_transfer: document.getElementById('method-local'),
        other: document.getElementById('method-other'),
    };

    function sync() {
        const selected = select.value;
        Object.entries(sections).forEach(([key, el]) => {
            if (!el) return;
            el.style.display = key === selected ? 'block' : 'none';
        });
    }

    select.addEventListener('change', sync);
    sync();
})();
</script>
@endpush
