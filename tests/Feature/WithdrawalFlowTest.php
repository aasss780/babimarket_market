<?php

use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Withdrawal;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);
});

it('lets seller request withdrawal within balance and admin approve', function () {
    $admin = User::where('email', 'admin@babimarket.com')->first();
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active', 'name' => 'Seller W']);
    $customer = User::factory()->create(['role' => 'customer', 'status' => 'active']);
    $category = Category::create(['name' => 'CatW']);
    $product = Product::create([
        'seller_id' => $seller->id,
        'category_id' => $category->id,
        'name' => 'Widget',
        'description' => 'D',
        'price' => 10,
        'stock' => 5,
        'status' => 'active',
    ]);
    $order = Order::create([
        'user_id' => $customer->id,
        'total_price' => 30,
        'status' => 'pending',
        'payment_method' => 'cash_on_delivery',
        'shipping_name' => 'C',
        'shipping_phone' => '1',
        'shipping_address' => 'Addr',
        'notes' => null,
    ]);
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'seller_id' => $seller->id,
        'quantity' => 2,
        'price' => 10,
    ]);

    $this->actingAs($seller)->get('/seller/withdrawals')->assertOk()->assertSee('$0.00');

    $order->update(['status' => 'processing']);

    $this->actingAs($seller)->post('/seller/withdrawals', [
        'amount' => 50,
        'payment_method' => 'paypal',
        'paypal_email' => 'seller@example.com',
    ])->assertSessionHasErrors();

    $this->actingAs($seller)->post('/seller/withdrawals', [
        'amount' => 15,
        'payment_method' => 'paypal',
        'paypal_email' => 'seller@example.com',
    ])->assertRedirect('/seller/withdrawals');

    // Pending withdrawal reduces available balance (20 - 15 = 5)
    $this->actingAs($seller)->post('/seller/withdrawals', [
        'amount' => 10,
        'payment_method' => 'paypal',
        'paypal_email' => 'seller@example.com',
    ])->assertSessionHasErrors();

    $this->assertDatabaseHas('withdrawals', [
        'seller_id' => $seller->id,
        'status' => Withdrawal::STATUS_PENDING,
    ]);

    expect(Notification::where('user_id', $admin->id)->where('type', 'withdrawal')->count())->toBeGreaterThan(0);

    $withdrawal = Withdrawal::where('seller_id', $seller->id)->firstOrFail();

    $this->actingAs($admin)->post("/admin/withdrawals/{$withdrawal->id}/approve")->assertRedirect();

    $withdrawal->refresh();
    expect($withdrawal->status)->toBe(Withdrawal::STATUS_APPROVED)
        ->and($withdrawal->approved_at)->not->toBeNull();

    expect(Notification::where('user_id', $seller->id)->where('title', 'Withdrawal approved')->count())->toBe(1);
});

it('lets admin reject a pending withdrawal', function () {
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $customer = User::factory()->create(['role' => 'customer', 'status' => 'active']);
    $admin = User::where('email', 'admin@babimarket.com')->first();
    $category = Category::create(['name' => 'CatR']);
    $product = Product::create([
        'seller_id' => $seller->id,
        'category_id' => $category->id,
        'name' => 'P',
        'description' => 'D',
        'price' => 5,
        'stock' => 3,
        'status' => 'active',
    ]);
    $order = Order::create([
        'user_id' => $customer->id,
        'total_price' => 5,
        'status' => 'delivered',
        'payment_method' => 'cash_on_delivery',
        'shipping_name' => 'C',
        'shipping_phone' => '1',
        'shipping_address' => 'Addr',
        'notes' => null,
    ]);
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'seller_id' => $seller->id,
        'quantity' => 1,
        'price' => 5,
    ]);

    $w = Withdrawal::create([
        'seller_id' => $seller->id,
        'amount' => 3,
        'payment_method' => 'bank_transfer',
        'payment_details' => 'IBAN TEST',
        'status' => Withdrawal::STATUS_PENDING,
    ]);

    $this->actingAs($admin)->post("/admin/withdrawals/{$w->id}/reject")->assertRedirect();

    $w->refresh();
    expect($w->status)->toBe(Withdrawal::STATUS_REJECTED)
        ->and($w->rejected_at)->not->toBeNull();

    expect(Notification::where('user_id', $seller->id)->where('title', 'Withdrawal rejected')->count())->toBe(1);
});

it('calculates 2 percent commission and limits both seller/admin withdrawals', function () {
    $admin = User::where('email', 'admin@babimarket.com')->first();
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $customer = User::factory()->create(['role' => 'customer', 'status' => 'active']);
    $category = Category::create(['name' => 'Commission Cat']);
    $product = Product::create([
        'seller_id' => $seller->id,
        'category_id' => $category->id,
        'name' => 'Commission Product',
        'description' => 'D',
        'price' => 100,
        'stock' => 3,
        'status' => 'active',
    ]);

    $order = Order::create([
        'user_id' => $customer->id,
        'total_price' => 100,
        'status' => 'pending',
        'payment_method' => 'cash_on_delivery',
        'shipping_name' => 'C',
        'shipping_phone' => '1',
        'shipping_address' => 'Addr',
        'notes' => null,
    ]);
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'seller_id' => $seller->id,
        'quantity' => 1,
        'price' => 100,
    ]);

    $this->actingAs($seller)->post('/seller/withdrawals', [
        'amount' => 1,
        'payment_method' => 'paypal',
        'paypal_email' => 'seller@example.com',
    ])->assertSessionHasErrors();

    $order->update(['status' => 'processing']);

    $this->actingAs($seller)->post('/seller/withdrawals', [
        'amount' => 99,
        'payment_method' => 'paypal',
        'paypal_email' => 'seller@example.com',
    ])->assertSessionHasErrors();

    $this->actingAs($seller)->post('/seller/withdrawals', [
        'amount' => 98,
        'payment_method' => 'paypal',
        'paypal_email' => 'seller@example.com',
    ])->assertRedirect('/seller/withdrawals');

    $this->actingAs($admin)->post('/admin/withdrawals', [
        'amount' => 3,
        'payment_method' => 'other',
        'payment_details' => 'Admin payout',
    ])->assertSessionHasErrors();

    $this->actingAs($admin)->post('/admin/withdrawals', [
        'amount' => 2,
        'payment_method' => 'other',
        'payment_details' => 'Admin payout',
    ])->assertRedirect();
});
