<?php

namespace App\Support;

use App\Models\OrderItem;
use App\Models\Withdrawal;

class AdminCommissionMetrics
{
    public static function forAdmin(int $adminId): array
    {
        $totalCommission = (float) OrderItem::query()
            ->whereHas('order', fn ($q) => $q->whereIn('status', SellerWithdrawalMetrics::EARNING_ORDER_STATUSES))
            ->get()
            ->sum(fn ($item) => ((float) $item->quantity * (float) $item->price) * SellerWithdrawalMetrics::PLATFORM_COMMISSION_RATE);

        $pendingWithdrawals = (float) Withdrawal::query()
            ->where('seller_id', $adminId)
            ->where('status', Withdrawal::STATUS_PENDING)
            ->sum('amount');

        $approvedWithdrawals = (float) Withdrawal::query()
            ->where('seller_id', $adminId)
            ->where('status', Withdrawal::STATUS_APPROVED)
            ->sum('amount');

        $availableBalance = max(0, $totalCommission - $approvedWithdrawals - $pendingWithdrawals);

        return [
            'total_commission' => round($totalCommission, 2),
            'pending_withdrawals' => round($pendingWithdrawals, 2),
            'approved_withdrawals' => round($approvedWithdrawals, 2),
            'available_balance' => round($availableBalance, 2),
        ];
    }
}

