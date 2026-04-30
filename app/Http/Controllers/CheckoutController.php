<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $items = $cart->items()->with('product')->get();

        return view('checkout', compact('items'));
    }

    public function store(Request $request)
    {
        $baseRules = [
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_phone' => ['required', 'string', 'max:60'],
            'city' => ['required', 'string', 'max:255'],
            'shipping_address' => ['required', 'string'],
            'payment_method' => ['required', Rule::in(['cash_on_delivery', 'credit_card', 'paypal'])],
            'notes' => ['nullable', 'string'],
            'card_holder' => ['nullable', 'string', 'max:255'],
            'card_number' => ['nullable', 'string', 'max:30'],
            'card_expiry' => ['nullable', 'string', 'max:12'],
            'card_cvv' => ['nullable', 'string', 'max:6'],
            'paypal_email' => ['nullable', 'string', 'max:255'],
        ];

        $data = $request->validate($baseRules);

        if ($data['payment_method'] === 'credit_card') {
            $request->validate([
                'card_holder' => ['required', 'string', 'min:3', 'max:255'],
                'card_number' => ['required', 'string', function (string $attribute, mixed $value, \Closure $fail) {
                    $digits = preg_replace('/\D/', '', (string) $value);
                    $len = strlen($digits);
                    if ($len < 13 || $len > 19) {
                        $fail('The card number must be between 13 and 19 digits (spaces are allowed).');
                    }
                }],
                'card_expiry' => ['required', 'string', function (string $attribute, mixed $value, \Closure $fail) {
                    $msg = self::validateCardExpiryMessage((string) $value);
                    if ($msg !== null) {
                        $fail($msg);
                    }
                }],
                'card_cvv' => ['required', 'string', 'regex:/^\d{3,4}$/'],
            ], [
                'card_cvv.regex' => 'The CVV must be 3 or 4 digits.',
            ]);
        }

        if ($data['payment_method'] === 'paypal') {
            $request->validate([
                'paypal_email' => ['required', 'email', 'max:255'],
            ]);
        }

        DB::transaction(function () use ($request, $data) {
            $cart = Cart::where('user_id', $request->user()->id)->lockForUpdate()->first();
            if (! $cart) {
                throw ValidationException::withMessages(['checkout' => ['Your cart is empty.']]);
            }

            $items = CartItem::where('cart_id', $cart->id)->orderBy('product_id')->get();
            if ($items->isEmpty()) {
                throw ValidationException::withMessages(['checkout' => ['Your cart is empty.']]);
            }

            foreach ($items as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();
                if (! $product || $product->status !== 'active') {
                    throw ValidationException::withMessages([
                        'checkout' => ['A product in your cart is no longer available.'],
                    ]);
                }
                if ($product->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'checkout' => ["Only {$product->stock} items available for {$product->name}."],
                    ]);
                }
            }

            $total = 0;
            foreach ($items as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();
                $total += $item->quantity * $product->price;
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'total_price' => $total,
                'status' => 'pending',
                'payment_method' => $data['payment_method'],
                'shipping_name' => $data['shipping_name'],
                'shipping_phone' => $data['shipping_phone'],
                'shipping_address' => $data['city'].' - '.$data['shipping_address'],
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($items as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();
                $newStock = $product->stock - $item->quantity;
                if ($newStock < 0) {
                    throw ValidationException::withMessages([
                        'checkout' => ["Only {$product->stock} items available for {$product->name}."],
                    ]);
                }
                $product->update(['stock' => $newStock]);

                $order->items()->create([
                    'product_id' => $item->product_id,
                    'seller_id' => $product->seller_id,
                    'quantity' => $item->quantity,
                    'price' => $product->price,
                ]);
                Notification::create([
                    'user_id' => $product->seller_id,
                    'title' => 'New order received',
                    'message' => 'A customer ordered '.$product->name,
                    'type' => 'order',
                ]);
            }

            CartItem::where('cart_id', $cart->id)->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Order placed');
    }

    /**
     * @return string|null Error message, or null if valid / not applicable
     */
    public static function validateCardExpiryMessage(string $expiry): ?string
    {
        $e = strtoupper(preg_replace('/\s+/', '', trim($expiry)));
        if ($e === '') {
            return 'The expiry date is required.';
        }
        if (! preg_match('/^(0[1-9]|1[0-2])\/(\d{2}|\d{4})$/', $e, $m)) {
            return 'Enter a valid expiry date (MM/YY or MM/YYYY), month 01–12.';
        }
        $month = (int) $m[1];
        $yPart = $m[2];
        if (strlen($yPart) === 2) {
            $year = 2000 + (int) $yPart;
        } else {
            $year = (int) $yPart;
        }
        if ($year < 1 || $year > 9999) {
            return 'Enter a valid expiry year.';
        }
        $now = Carbon::now();
        if ($year < $now->year) {
            return 'This card has expired. Use a future expiry date.';
        }
        if ($year === $now->year && $month < $now->month) {
            return 'This card has expired. Use a future expiry date.';
        }

        return null;
    }
}
