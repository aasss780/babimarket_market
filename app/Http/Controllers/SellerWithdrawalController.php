<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Withdrawal;
use App\Support\SellerWithdrawalMetrics;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SellerWithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = $request->user()->id;
        $metrics = SellerWithdrawalMetrics::forSeller($sellerId);
        $withdrawals = Withdrawal::where('seller_id', $sellerId)->latest()->get();

        return view('seller.withdrawals', compact('metrics', 'withdrawals'));
    }

    public function store(Request $request)
    {
        $sellerId = $request->user()->id;
        $metrics = SellerWithdrawalMetrics::forSeller($sellerId);
        $max = $metrics['available_balance'];

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'lte:'.$max],
            'payment_method' => ['required', 'string', Rule::in(['bank_transfer', 'paypal', 'cash_pickup', 'local_transfer', 'other'])],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'account_holder_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'iban' => ['nullable', 'string', 'max:255'],
            'bank_phone' => ['nullable', 'string', 'max:255'],
            'paypal_email' => ['nullable', 'email', 'max:255'],
            'cash_full_name' => ['nullable', 'string', 'max:255'],
            'cash_phone' => ['nullable', 'string', 'max:255'],
            'pickup_branch' => ['nullable', 'string', 'max:255'],
            'pickup_note' => ['nullable', 'string', 'max:1000'],
            'local_full_name' => ['nullable', 'string', 'max:255'],
            'local_phone' => ['nullable', 'string', 'max:255'],
            'transfer_service_name' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_details' => ['nullable', 'string', 'max:1000'],
        ]);

        $method = $data['payment_method'];
        if ($method === 'bank_transfer') {
            $request->validate([
                'bank_name' => ['required', 'string', 'max:255'],
                'account_holder_name' => ['required', 'string', 'max:255'],
                'account_number' => ['required', 'string', 'max:255'],
                'iban' => ['nullable', 'string', 'max:255'],
                'bank_phone' => ['nullable', 'string', 'max:255'],
            ]);
        } elseif ($method === 'paypal') {
            $request->validate([
                'paypal_email' => ['required', 'email', 'max:255'],
            ]);
        } elseif ($method === 'cash_pickup') {
            $request->validate([
                'cash_full_name' => ['required', 'string', 'max:255'],
                'cash_phone' => ['required', 'string', 'max:255'],
                'pickup_branch' => ['nullable', 'string', 'max:255'],
                'pickup_note' => ['nullable', 'string', 'max:1000'],
            ]);
            if (! $request->filled('pickup_branch') && ! $request->filled('pickup_note')) {
                return back()
                    ->withInput()
                    ->withErrors(['pickup_branch' => 'Pickup branch or pickup note is required for cash pickup.']);
            }
        } elseif ($method === 'local_transfer') {
            $request->validate([
                'local_full_name' => ['required', 'string', 'max:255'],
                'local_phone' => ['required', 'string', 'max:255'],
                'transfer_service_name' => ['required', 'string', 'max:255'],
                'notes' => ['nullable', 'string', 'max:1000'],
            ]);
        } else {
            $request->validate([
                'payment_details' => ['required', 'string', 'max:1000'],
            ]);
        }

        $paymentDetails = $this->buildPaymentDetails($request, $method);

        Withdrawal::create([
            'seller_id' => $sellerId,
            'amount' => $data['amount'],
            'payment_method' => $method,
            'payment_details' => $paymentDetails,
            'status' => Withdrawal::STATUS_PENDING,
        ]);

        foreach (User::where('role', 'admin')->cursor() as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'New withdrawal request',
                'message' => $request->user()->name.' requested a withdrawal of $'.number_format((float) $data['amount'], 2).'.',
                'type' => 'withdrawal',
                'is_read' => false,
            ]);
        }

        return redirect()->route('seller.withdrawals')
            ->with('success', 'Withdrawal request submitted and waiting for admin approval.');
    }

    private function buildPaymentDetails(Request $request, string $method): string
    {
        $details = [];
        if ($method === 'bank_transfer') {
            $details = [
                'bank_name' => $request->input('bank_name'),
                'account_holder_name' => $request->input('account_holder_name'),
                'account_number' => $request->input('account_number'),
                'iban' => $request->input('iban'),
                'phone' => $request->input('bank_phone'),
            ];
        } elseif ($method === 'paypal') {
            $details = [
                'paypal_email' => $request->input('paypal_email'),
            ];
        } elseif ($method === 'cash_pickup') {
            $details = [
                'full_name' => $request->input('cash_full_name'),
                'phone' => $request->input('cash_phone'),
                'pickup_branch' => $request->input('pickup_branch'),
                'pickup_note' => $request->input('pickup_note'),
            ];
        } elseif ($method === 'local_transfer') {
            $details = [
                'full_name' => $request->input('local_full_name'),
                'phone' => $request->input('local_phone'),
                'transfer_service_name' => $request->input('transfer_service_name'),
                'notes' => $request->input('notes'),
            ];
        } else {
            $details = [
                'payment_details' => $request->input('payment_details'),
            ];
        }

        return (string) json_encode($details, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
