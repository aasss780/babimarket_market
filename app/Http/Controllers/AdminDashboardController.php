<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Support\SellerWithdrawalMetrics;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalCommission = (float) OrderItem::query()
            ->whereHas('order', fn ($q) => $q->whereIn('status', SellerWithdrawalMetrics::EARNING_ORDER_STATUSES))
            ->get()
            ->sum(fn ($item) => ((float) $item->quantity * (float) $item->price) * SellerWithdrawalMetrics::PLATFORM_COMMISSION_RATE);

        return view('admin.dashboard', [
            'stats' => [
                'total_users' => User::count(),
                'total_sellers' => User::where('role', 'seller')->count(),
                'total_customers' => User::where('role', 'customer')->count(),
                'total_products' => Product::count(),
                'total_orders' => Order::count(),
                'total_revenue' => $totalCommission,
            ],
        ]);
    }

    public function orders()
    {
        return view('admin.orders', ['orders' => Order::latest()->get()]);
    }
}
