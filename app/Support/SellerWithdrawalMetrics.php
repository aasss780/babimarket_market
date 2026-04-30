<?php

namespace App\Support;

use App\Models\OrderItem;
use App\Models\Withdrawal;

/**
 * Earnings = sum of (quantity × price) for this seller's order lines where order status
 * is accepted, processing, or delivered.
 * Available = earnings − approved withdrawals − pending withdrawals.
 */
class SellerWithdrawalMetrics
{
    public const PLATFORM_COMMISSION_RATE = 0.02;

    public const EARNING_ORDER_STATUSES = ['accepted', 'processing', 'delivered'];

    /**
     * @return array{total_earnings: float, pending_withdrawals: float, approved_withdrawals: float, available_balance: float}
     */
    public static function forSeller(int $sellerId): array
    {
        $totalEarnings = (float) OrderItem::query()
            ->where('seller_id', $sellerId)
            ->whereHas('order', fn ($q) => $q->whereIn('status', self::EARNING_ORDER_STATUSES))
            ->get()
            ->sum(function ($item) {
                $gross = (float) $item->quantity * (float) $item->price;
                $commission = $gross * self::PLATFORM_COMMISSION_RATE;

                return $gross - $commission;
            });

        $pendingWithdrawals = (float) Withdrawal::query()
            ->where('seller_id', $sellerId)
            ->where('status', Withdrawal::STATUS_PENDING)
            ->sum('amount');

        $approvedWithdrawals = (float) Withdrawal::query()
            ->where('seller_id', $sellerId)
            ->where('status', Withdrawal::STATUS_APPROVED)
            ->sum('amount');

        $availableBalance = max(0, $totalEarnings - $approvedWithdrawals - $pendingWithdrawals);

        return [
            'total_earnings' => round($totalEarnings, 2),
            'pending_withdrawals' => round($pendingWithdrawals, 2),
            'approved_withdrawals' => round($approvedWithdrawals, 2),
            'available_balance' => round($availableBalance, 2),
        ];
    }
}
