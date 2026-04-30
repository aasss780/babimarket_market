<?php

use App\Models\Cart;
use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);
});

it('enforces guest and role navigation rules', function () {
    $this->get('/')->assertOk()->assertSee('Login')->assertSee('Register');

    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $this->actingAs($seller)->get('/')->assertRedirect('/seller/dashboard');
    $this->actingAs($seller)->get('/products')->assertRedirect('/seller/dashboard');

    $admin = User::where('email', 'admin@babimarket.com')->first();
    $this->actingAs($admin)->get('/')->assertRedirect('/admin/dashboard');
});

it('handles checkout credit card validation and pending order', function () {
    $customer = User::factory()->create(['role' => 'customer', 'status' => 'active']);
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $category = Category::create(['name' => 'Cat']);
    $product = Product::create([
        'seller_id' => $seller->id, 'category_id' => $category->id, 'name' => 'P', 'description' => 'D', 'price' => 10, 'stock' => 10, 'status' => 'active',
    ]);

    $this->actingAs($customer)->post("/cart/add/{$product->id}");

    $this->post('/checkout', [
        'shipping_name' => 'C',
        'shipping_phone' => '123',
        'city' => 'City',
        'shipping_address' => 'Street',
        'payment_method' => 'credit_card',
    ])->assertSessionHasErrors(['card_holder', 'card_number', 'card_expiry', 'card_cvv']);

    $this->post('/checkout', [
        'shipping_name' => 'C',
        'shipping_phone' => '123',
        'city' => 'City',
        'shipping_address' => 'Street',
        'payment_method' => 'credit_card',
        'card_holder' => 'Holder',
        'card_number' => '4111111111111111',
        'card_expiry' => '12/30',
        'card_cvv' => '123',
    ])->assertRedirect('/orders');

    $this->assertDatabaseHas('orders', ['user_id' => $customer->id, 'status' => 'pending']);

    $this->actingAs($customer)->post("/cart/add/{$product->id}");
    $this->post('/checkout', [
        'shipping_name' => 'C',
        'shipping_phone' => '123',
        'city' => 'City',
        'shipping_address' => 'Street',
        'payment_method' => 'credit_card',
        'card_holder' => 'John Doe',
        'card_number' => '4111 1111 1111 1111',
        'card_expiry' => '01/20',
        'card_cvv' => '123',
    ])->assertSessionHasErrors('card_expiry');

    $this->post('/checkout', [
        'shipping_name' => 'C',
        'shipping_phone' => '123',
        'city' => 'City',
        'shipping_address' => 'Street',
        'payment_method' => 'credit_card',
        'card_holder' => 'Jo',
        'card_number' => '4111111111111111',
        'card_expiry' => '12/35',
        'card_cvv' => '123',
    ])->assertSessionHasErrors('card_holder');

    $this->post('/checkout', [
        'shipping_name' => 'C',
        'shipping_phone' => '123',
        'city' => 'City',
        'shipping_address' => 'Street',
        'payment_method' => 'paypal',
    ])->assertSessionHasErrors('paypal_email');

    $this->post('/checkout', [
        'shipping_name' => 'C',
        'shipping_phone' => '123',
        'city' => 'City',
        'shipping_address' => 'Street',
        'payment_method' => 'paypal',
        'paypal_email' => 'buyer@example.com',
    ])->assertRedirect('/orders');
});

it('lets seller accept reject and notifies customer', function () {
    $customer = User::factory()->create(['role' => 'customer', 'status' => 'active']);
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $category = Category::create(['name' => 'Cat']);
    $product = Product::create([
        'seller_id' => $seller->id, 'category_id' => $category->id, 'name' => 'P', 'description' => 'D', 'price' => 10, 'stock' => 10, 'status' => 'active',
    ]);
    $order = Order::create([
        'user_id' => $customer->id, 'total_price' => 10, 'status' => 'pending', 'payment_method' => 'cash_on_delivery', 'shipping_name' => 'C', 'shipping_phone' => '123', 'shipping_address' => 'City - Street',
    ]);
    $item = OrderItem::create(['order_id' => $order->id, 'product_id' => $product->id, 'seller_id' => $seller->id, 'quantity' => 1, 'price' => 10]);

    $this->actingAs($seller)->post("/seller/orders/{$item->id}/status", ['status' => 'processing'])->assertRedirect();
    $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'processing']);

    $this->actingAs($customer)->get('/orders')->assertSee('Processing');
});

it('supports avatar upload and messaging flows', function () {
    Storage::fake('public');
    $customer = User::factory()->create(['role' => 'customer', 'status' => 'active', 'avatar' => null]);
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $category = Category::create(['name' => 'Cat']);
    $product = Product::create([
        'seller_id' => $seller->id, 'category_id' => $category->id, 'name' => 'P', 'description' => 'D', 'price' => 10, 'stock' => 10, 'status' => 'active',
    ]);

    $this->actingAs($customer)->post('/profile', [
        'name' => $customer->name,
        'phone' => '',
        'address' => '',
        'avatar' => UploadedFile::fake()->image('avatar.jpg'),
    ])->assertRedirect();
    $this->assertDatabaseMissing('users', ['id' => $customer->id, 'avatar' => null]);

    $this->actingAs($customer)->post('/messages', [
        'receiver_id' => $seller->id,
        'product_id' => $product->id,
        'message' => 'Hello seller',
    ])->assertRedirect();
    $this->assertDatabaseHas('messages', ['sender_id' => $customer->id, 'receiver_id' => $seller->id, 'product_id' => $product->id]);

    auth()->logout();
    $this->get('/contact')->assertRedirect('/login');

    $admin = User::where('email', 'admin@babimarket.com')->first();
    $this->actingAs($customer)->post('/messages', [
        'receiver_id' => $admin->id,
        'product_id' => null,
        'message' => 'Contact admin',
    ])->assertRedirect();
    $this->assertDatabaseHas('messages', ['sender_id' => $customer->id, 'receiver_id' => $admin->id, 'product_id' => null]);
});

it('keeps product conversations separated and marks notifications read', function () {
    $customer = User::factory()->create(['role' => 'customer', 'status' => 'active']);
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $category = Category::create(['name' => 'Cat']);
    $productA = Product::create(['seller_id' => $seller->id, 'category_id' => $category->id, 'name' => 'A', 'description' => 'A', 'price' => 10, 'stock' => 2, 'status' => 'active']);
    $productB = Product::create(['seller_id' => $seller->id, 'category_id' => $category->id, 'name' => 'B', 'description' => 'B', 'price' => 11, 'stock' => 2, 'status' => 'active']);

    $this->actingAs($customer)->post('/messages', [
        'receiver_id' => $seller->id,
        'product_id' => $productA->id,
        'message' => 'Question for A',
    ]);
    $this->post('/messages', [
        'receiver_id' => $seller->id,
        'product_id' => $productB->id,
        'message' => 'Question for B',
    ]);

    $this->get('/messages?receiver_id='.$seller->id.'&product_id='.$productB->id)
        ->assertSee('Question for B')
        ->assertSee('product_id" value="'.$productB->id.'"', false);

    $seller->refresh();
    $this->actingAs($seller)->post('/messages', [
        'receiver_id' => $customer->id,
        'product_id' => $productB->id,
        'message' => 'Reply on B',
    ]);
    $this->assertDatabaseHas('notifications', ['user_id' => $customer->id, 'type' => 'message', 'is_read' => false]);

    $this->actingAs($customer)->get('/notifications')->assertOk()->assertSee('New message');
    $this->assertDatabaseMissing('notifications', ['user_id' => $customer->id, 'type' => 'message', 'is_read' => false]);
});

it('uses seller dashboard layout across seller pages', function () {
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $category = Category::create(['name' => 'Cat']);
    $product = Product::create([
        'seller_id' => $seller->id, 'category_id' => $category->id, 'name' => 'Seller Product', 'description' => 'Desc', 'price' => 25, 'stock' => 6, 'status' => 'active',
    ]);

    $this->actingAs($seller)->get('/seller/dashboard')->assertOk()->assertSee('Dashboard')->assertDontSee('Home');
    $this->actingAs($seller)->get('/seller/products')->assertOk()->assertSee('My Products')->assertSee('Seller Product')->assertDontSee('Home');
    $this->actingAs($seller)->get('/seller/products/create')->assertOk()->assertSee('Add Product')->assertDontSee('Home');
    $this->actingAs($seller)->get("/seller/products/{$product->id}/edit")->assertOk()->assertSee('Edit Product')->assertDontSee('Home');
    $this->actingAs($seller)->get('/seller/orders')->assertOk()->assertSee('Seller Orders')->assertDontSee('Home');
    $this->actingAs($seller)->get('/seller/messages')->assertOk()->assertSee('Seller Messages')->assertDontSee('Home');
    $this->actingAs($seller)->get('/seller/notifications')->assertOk()->assertSee('Notifications')->assertDontSee('Home');
    $this->actingAs($seller)->get('/seller/profile/edit')->assertOk()->assertSee('Edit Profile')->assertDontSee('Home');
});

it('updates seller profile and avatar without affecting customer profile route', function () {
    Storage::fake('public');
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active', 'avatar' => null]);
    $customer = User::factory()->create(['role' => 'customer', 'status' => 'active']);

    $this->actingAs($seller)->post('/seller/profile/update', [
        'name' => 'Seller Updated',
        'email' => $seller->email,
        'phone' => '12345',
        'address' => 'Seller street',
        'store_name' => 'My Store',
        'store_description' => 'Best products',
        'avatar' => UploadedFile::fake()->image('seller.jpg'),
    ])->assertRedirect('/seller/profile/edit');

    $this->assertDatabaseHas('users', ['id' => $seller->id, 'name' => 'Seller Updated', 'store_name' => 'My Store']);
    $this->assertDatabaseMissing('users', ['id' => $seller->id, 'avatar' => null]);

    $this->actingAs($seller)->get('/seller/dashboard')->assertSee('Seller Updated');
    $this->actingAs($customer)->get('/seller/profile/edit')->assertStatus(403);
});
