@extends('layouts.admin')

@section('page_title', 'Withdrawals')

@section('content')
    <p class="muted" style="margin-bottom:18px;">Review seller payout requests. Approve or reject pending items.</p>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:18px;">
        <div class="card" style="margin:0;">
            <h3 style="font-size:24px;font-weight:800;color:var(--primary);">${{ number_format($metrics['available_balance'], 2) }}</h3>
            <p class="muted" style="margin-top:6px;">Admin available commission</p>
            <p class="muted" style="font-size:11px;margin-top:4px;">Platform commission rate: 2%</p>
        </div>
        <div class="card" style="margin:0;">
            <h3 style="font-size:24px;font-weight:800;">${{ number_format($metrics['total_commission'], 2) }}</h3>
            <p class="muted" style="margin-top:6px;">Total commission earned</p>
        </div>
        <div class="card" style="margin:0;">
            <h3 style="font-size:24px;font-weight:800;">${{ number_format($metrics['pending_withdrawals'], 2) }}</h3>
            <p class="muted" style="margin-top:6px;">Admin pending withdrawals</p>
        </div>
        <div class="card" style="margin:0;">
            <h3 style="font-size:24px;font-weight:800;">${{ number_format($metrics['approved_withdrawals'], 2) }}</h3>
            <p class="muted" style="margin-top:6px;">Admin approved withdrawals</p>
        </div>
    </div>

    <div class="card" style="margin-bottom:18px;">
        <h3 style="margin-bottom:12px;">Request admin commission withdrawal</h3>
        @if($metrics['available_balance'] < 1)
            <p class="muted">No commission available to withdraw yet.</p>
        @else
            <form method="POST" action="{{ route('admin.withdrawals.store') }}" id="admin-withdrawal-form" style="max-width:680px;">
                @csrf
                <label class="muted" style="display:block;margin-bottom:6px;">Amount (max ${{ number_format($metrics['available_balance'], 2) }})</label>
                <input type="number" name="amount" step="0.01" min="1" max="{{ $metrics['available_balance'] }}" value="{{ old('amount') }}" required>
                <label class="muted" style="display:block;margin:10px 0 6px;">Payment method</label>
                <select name="payment_method" id="admin_payment_method" required>
                    <option value="">Select…</option>
                    <option value="bank_transfer" @selected(old('payment_method')==='bank_transfer')>Bank Transfer</option>
                    <option value="paypal" @selected(old('payment_method')==='paypal')>PayPal</option>
                    <option value="cash_pickup" @selected(old('payment_method')==='cash_pickup')>Cash Office Pickup</option>
                    <option value="local_transfer" @selected(old('payment_method')==='local_transfer')>Wish Money / OMT / Local Transfer</option>
                    <option value="other" @selected(old('payment_method')==='other')>Other</option>
                </select>

                <div id="admin-method-bank" style="display:none;margin-top:12px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div><label class="muted">Bank name</label><input type="text" name="bank_name" value="{{ old('bank_name') }}"></div>
                        <div><label class="muted">Account holder name</label><input type="text" name="account_holder_name" value="{{ old('account_holder_name') }}"></div>
                        <div><label class="muted">Account number</label><input type="text" name="account_number" value="{{ old('account_number') }}"></div>
                        <div><label class="muted">IBAN (optional)</label><input type="text" name="iban" value="{{ old('iban') }}"></div>
                        <div><label class="muted">Phone (optional)</label><input type="text" name="bank_phone" value="{{ old('bank_phone') }}"></div>
                    </div>
                </div>
                <div id="admin-method-paypal" style="display:none;margin-top:12px;">
                    <label class="muted">PayPal email</label>
                    <input type="email" name="paypal_email" value="{{ old('paypal_email') }}">
                </div>
                <div id="admin-method-cash" style="display:none;margin-top:12px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div><label class="muted">Full name</label><input type="text" name="cash_full_name" value="{{ old('cash_full_name') }}"></div>
                        <div><label class="muted">Phone</label><input type="text" name="cash_phone" value="{{ old('cash_phone') }}"></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px;">
                        <div><label class="muted">Pickup branch</label><input type="text" name="pickup_branch" value="{{ old('pickup_branch') }}"></div>
                        <div><label class="muted">Pickup note</label><input type="text" name="pickup_note" value="{{ old('pickup_note') }}"></div>
                    </div>
                </div>
                <div id="admin-method-local" style="display:none;margin-top:12px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div><label class="muted">Full name</label><input type="text" name="local_full_name" value="{{ old('local_full_name') }}"></div>
                        <div><label class="muted">Phone</label><input type="text" name="local_phone" value="{{ old('local_phone') }}"></div>
                    </div>
                    <div style="margin-top:12px;"><label class="muted">Transfer service name</label><input type="text" name="transfer_service_name" value="{{ old('transfer_service_name') }}"></div>
                    <div style="margin-top:12px;"><label class="muted">Notes (optional)</label><textarea name="notes" rows="3" maxlength="1000">{{ old('notes') }}</textarea></div>
                </div>
                <div id="admin-method-other" style="display:none;margin-top:12px;">
                    <label class="muted">Payment details</label>
                    <textarea name="payment_details" rows="3" maxlength="1000" placeholder="Bank account / payout note">{{ old('payment_details') }}</textarea>
                </div>
                <button class="btn" type="submit" style="margin-top:10px;">Request withdrawal</button>
            </form>
        @endif
    </div>

    <div class="card" style="margin-bottom:18px;">
        <h3 style="margin-bottom:12px;">Admin commission withdrawal history</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($adminWithdrawals as $w)
                        @php
                            $adminDecoded = json_decode((string) $w->payment_details, true);
                            if (! is_array($adminDecoded)) {
                                $adminDecoded = ['payment_details' => $w->payment_details];
                            }
                            $adminMethodLabel = match ($w->payment_method) {
                                'bank_transfer' => 'Bank Transfer',
                                'paypal' => 'PayPal',
                                'cash_pickup' => 'Cash Office Pickup',
                                'local_transfer' => 'Wish Money / OMT / Local Transfer',
                                'other' => 'Other',
                                default => $w->payment_method,
                            };
                        @endphp
                        <tr>
                            <td>${{ number_format((float)$w->amount, 2) }}</td>
                            <td class="muted">
                                <div><strong style="color:#444;">{{ $adminMethodLabel }}</strong></div>
                                @foreach($adminDecoded as $k => $v)
                                    @if(filled($v))
                                        <div>{{ ucwords(str_replace('_', ' ', (string) $k)) }}: {{ $v }}</div>
                                    @endif
                                @endforeach
                            </td>
                            <td><span style="padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;text-transform:capitalize;background:{{ $w->status==='approved' ? '#E8F5E9' : ($w->status==='rejected' ? '#FFEBEE' : '#FFF3E0') }};color:{{ $w->status==='approved' ? '#2E7D32' : ($w->status==='rejected' ? '#C62828' : '#E65100') }};">{{ $w->status }}</span></td>
                            <td class="muted">{{ $w->created_at?->format('M j, Y g:i a') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="muted" style="text-align:center;padding:20px;">No admin withdrawals yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <h3 style="font-size:18px;margin-bottom:10px;">Seller withdrawal requests</h3>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Seller</th>
                    <th>Email</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="text-align:right;">Actions</th>
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
                            'admin_commission' => 'Admin Commission',
                            'other' => 'Other',
                            default => $w->payment_method,
                        };
                        $decoded = json_decode((string) $w->payment_details, true);
                        if (! is_array($decoded)) {
                            $decoded = ['payment_details' => $w->payment_details];
                        }
                    @endphp
                    <tr>
                        <td><strong>{{ $w->seller->name ?? '—' }}</strong></td>
                        <td class="muted">{{ $w->seller->email ?? '—' }}</td>
                        <td>${{ number_format((float)$w->amount, 2) }}</td>
                        <td>{{ $methodLabel }}</td>
                        <td style="max-width:280px;font-size:13px;" class="muted">
                            @foreach($decoded as $k => $v)
                                @if(filled($v))
                                    <div><strong style="color:#444;">{{ ucwords(str_replace('_', ' ', (string) $k)) }}:</strong> {{ $v }}</div>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <span style="padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;text-transform:capitalize;background:{{ $w->status==='approved' ? '#E8F5E9' : ($w->status==='rejected' ? '#FFEBEE' : '#FFF3E0') }};color:{{ $w->status==='approved' ? '#2E7D32' : ($w->status==='rejected' ? '#C62828' : '#E65100') }};">{{ $w->status }}</span>
                        </td>
                        <td class="muted" style="font-size:13px;">{{ $w->created_at?->format('M j, Y') }}</td>
                        <td style="text-align:right;">
                            @if($w->status === \App\Models\Withdrawal::STATUS_PENDING)
                                <form method="POST" action="{{ route('admin.withdrawals.approve', $w) }}" style="display:inline;">@csrf<button type="submit" class="btn btn-sm">Approve</button></form>
                                <form method="POST" action="{{ route('admin.withdrawals.reject', $w) }}" style="display:inline;margin-left:6px;">@csrf<button type="submit" class="btn btn-sm btn-danger">Reject</button></form>
                            @else
                                <span class="muted" style="font-size:12px;">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="muted" style="text-align:center;padding:28px;">No withdrawal requests.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
<script>
(() => {
    const select = document.getElementById('admin_payment_method');
    if (!select) return;
    const sections = {
        bank_transfer: document.getElementById('admin-method-bank'),
        paypal: document.getElementById('admin-method-paypal'),
        cash_pickup: document.getElementById('admin-method-cash'),
        local_transfer: document.getElementById('admin-method-local'),
        other: document.getElementById('admin-method-other'),
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
