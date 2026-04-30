<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Notification;
use App\Support\SellerWithdrawalMetrics;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SellerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = $request->user()->id;
        $productsCount = Product::where('seller_id', $sellerId)->count();
        $orders = OrderItem::where('seller_id', $sellerId)->latest()->take(10)->get();
        $withdrawalMetrics = SellerWithdrawalMetrics::forSeller($sellerId);

        return view('seller.dashboard', compact('productsCount', 'orders', 'withdrawalMetrics'));
    }

    public function orders(Request $request)
    {
        $orders = OrderItem::with(['order.user', 'product.images'])->where('seller_id', $request->user()->id)->latest()->get();
        return view('seller.orders', compact('orders'));
    }

    public function messages(Request $request)
    {
        $sellerId = $request->user()->id;
        $base = \App\Models\Message::with(['sender', 'receiver', 'product'])
            ->whereNotNull('product_id')
            ->where(function ($q) use ($sellerId) {
                $q->where('sender_id', $sellerId)->orWhere('receiver_id', $sellerId);
            })
            ->latest()
            ->get();

        $threads = $base
            ->groupBy(function ($m) use ($sellerId) {
                $customerId = $m->sender_id === $sellerId ? $m->receiver_id : $m->sender_id;

                return $customerId.'_'.$m->product_id;
            })
            ->map(fn ($group) => $group->sortByDesc('id')->first())
            ->values()
            ->sortByDesc('created_at')
            ->values();

        $customerId = null;
        $productId = null;
        if ($request->filled('customer_id') && $request->filled('product_id')) {
            $customerId = (int) $request->input('customer_id');
            $productId = (int) $request->input('product_id');
        }

        $messages = collect();
        $customer = null;
        $product = null;

        if ($customerId && $productId) {
            $product = Product::find($productId);
            $customer = \App\Models\User::find($customerId);

            if (! $product || ! $customer || $customer->role !== 'customer'
                || (int) $product->seller_id !== (int) $sellerId) {
                return redirect()->route('seller.messages')
                    ->withErrors(['message' => 'Invalid thread. Choose a conversation from the list.']);
            }

            $messages = \App\Models\Message::with(['sender', 'receiver', 'product'])
                ->where('product_id', $productId)
                ->where(function ($q) use ($sellerId, $customerId) {
                    $q->where(function ($q2) use ($sellerId, $customerId) {
                        $q2->where('sender_id', $sellerId)->where('receiver_id', $customerId);
                    })->orWhere(function ($q2) use ($sellerId, $customerId) {
                        $q2->where('sender_id', $customerId)->where('receiver_id', $sellerId);
                    });
                })
                ->orderBy('created_at')
                ->get();

            \App\Models\Message::where('receiver_id', $sellerId)
                ->where('sender_id', $customerId)
                ->where('product_id', $productId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return view('seller.messages', [
            'threads' => $threads,
            'messages' => $messages,
            'customer' => $customer,
            'product' => $product,
            'customerId' => $customerId,
            'productId' => $productId,
        ]);
    }

    public function updateOrderStatus(Request $request, OrderItem $item)
    {
        if ($item->seller_id !== $request->user()->id) {
            abort(403);
        }

        $data = $request->validate(['status' => ['required', 'in:processing,cancelled']]);
        $item->order->update(['status' => $data['status']]);

        Notification::create([
            'user_id' => $item->order->user_id,
            'title' => 'Order status updated',
            'message' => 'Your order #'.$item->order_id.' is now '.$data['status'].'.',
            'type' => 'order',
        ]);

        return back()->with('success', 'Order status updated.');
    }

    public function editProfile(Request $request)
    {
        return view('seller.profile.edit', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($request->user()->id)],
            'phone' => ['nullable', 'string', 'max:60'],
            'address' => ['nullable', 'string'],
            'store_name' => ['nullable', 'string', 'max:255'],
            'store_description' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $request->user()->update($data);
        return redirect()->route('seller.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
