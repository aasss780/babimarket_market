<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);
});

it('loads public pages', function () {
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $category = Category::create(['name' => 'Public Cat']);
    $product = Product::create([
        'seller_id' => $seller->id,
        'category_id' => $category->id,
        'name' => 'Public Product',
        'description' => 'Public product desc',
        'price' => 11,
        'stock' => 2,
        'status' => 'active',
    ]);

    $this->get('/')->assertOk()->assertSee('Login')->assertSee('Register');
    $this->get('/products')->assertOk();
    $this->get('/products/'.$product->id)->assertOk();
    $this->get('/login')->assertOk();
    $this->get('/register')->assertOk();
});

it('registers customer and seller', function () {
    $this->post('/register', [
        'name' => 'Customer One',
        'email' => 'customer1@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'customer',
    ])->assertRedirect('/');
    $this->assertDatabaseHas('users', ['email' => 'customer1@example.com', 'role' => 'customer', 'avatar' => null]);

    auth()->logout();

    $this->post('/register', [
        'name' => 'Seller One',
        'email' => 'seller1@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'seller',
    ])->assertRedirect('/seller/dashboard');
    $this->assertDatabaseHas('users', ['email' => 'seller1@example.com', 'role' => 'seller']);
});

it('allows admin login and admin actions', function () {
    $targetUser = User::factory()->create(['role' => 'customer', 'status' => 'active']);
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $category = Category::create(['name' => 'Test Cat']);
    $product = Product::create([
        'seller_id' => $seller->id,
        'category_id' => $category->id,
        'name' => 'Test Product',
        'description' => 'Desc',
        'price' => 10,
        'stock' => 5,
        'status' => 'active',
    ]);

    $this->post('/login', [
        'email' => 'admin@babimarket.com',
        'password' => 'password',
    ])->assertRedirect('/admin/dashboard');

    $this->get('/admin/dashboard')->assertOk();
    $this->post("/admin/users/{$targetUser->id}/toggle-status")->assertRedirect();
    $this->delete("/admin/products/{$product->id}")->assertRedirect();
});

it('allows customer cart wishlist and checkout flow', function () {
    $customer = User::factory()->create(['role' => 'customer', 'status' => 'active']);
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $category = Category::create(['name' => 'Test Cat']);
    $product = Product::create([
        'seller_id' => $seller->id,
        'category_id' => $category->id,
        'name' => 'Test Product',
        'description' => 'Desc',
        'price' => 10,
        'stock' => 5,
        'status' => 'active',
    ]);

    $this->actingAs($customer);
    $this->get('/')->assertSee('Wishlist')->assertSee('Cart')->assertSee('Notifications')->assertSee('Logout');
    $this->get('/cart')->assertOk();
    $this->post("/cart/add/{$product->id}")->assertRedirect();
    $this->post("/cart/buy-now/{$product->id}")->assertRedirect('/checkout');
    $this->get('/wishlist')->assertOk();
    $this->post("/wishlist/add/{$product->id}")->assertRedirect();
    $this->assertDatabaseHas('wishlists', ['user_id' => $customer->id, 'product_id' => $product->id]);
    $this->post("/wishlist/add/{$product->id}")->assertRedirect();
    $this->assertDatabaseMissing('wishlists', ['user_id' => $customer->id, 'product_id' => $product->id]);
    $this->get('/checkout')->assertOk();
    $this->post('/checkout', [
        'shipping_name' => 'Customer One',
        'shipping_phone' => '12345678',
        'city' => 'City',
        'shipping_address' => 'Some address',
        'payment_method' => 'cash_on_delivery',
        'notes' => 'test',
    ])->assertRedirect('/orders');
    $product->refresh();
    expect((int) $product->stock)->toBe(3);
    $this->get('/profile')->assertOk();
    $this->get('/notifications')->assertOk();
    $this->post("/products/{$product->id}/reviews", [
        'rating' => 5,
        'comment' => 'Great product',
    ])->assertRedirect();
    $this->assertDatabaseHas('reviews', [
        'user_id' => $customer->id,
        'product_id' => $product->id,
        'rating' => 5,
    ]);
});

it('allows seller dashboard and adding product', function () {
    $seller = User::factory()->create(['role' => 'seller', 'status' => 'active']);
    $category = Category::create(['name' => 'Test Cat']);
    $this->actingAs($seller);

    $this->get('/seller/dashboard')->assertOk();
    $this->post('/seller/products', [
        'name' => 'Seller Product',
        'category_id' => $category->id,
        'description' => 'Desc',
        'price' => 20,
        'stock' => 7,
    ])->assertRedirect('/seller/products');
});
