@extends('layouts.admin')

@section('page_title', 'Orders')

@section('content')
    <p class="muted" style="margin-bottom:18px;">All customer orders across sellers.</p>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->user->name ?? '—' }}</td>
                        <td>${{ number_format($order->total_price, 2) }}</td>
                        <td><span style="text-transform:capitalize;">{{ $order->status }}</span></td>
                        <td class="muted">{{ $order->created_at?->format('M j, Y g:i a') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="muted" style="text-align:center;padding:28px;">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
