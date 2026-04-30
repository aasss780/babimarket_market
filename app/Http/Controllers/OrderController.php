<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('items')->where('user_id', $request->user()->id)->latest()->get();
        return view('orders.index', compact('orders'));
    }
}
