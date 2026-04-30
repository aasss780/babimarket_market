<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminWithdrawalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\SellerWithdrawalController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::middleware('shop_only')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.forgot');
    Route::post('/forgot-password', [AuthController::class, 'handleForgotPassword'])->name('password.forgot.post');
    Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'handleResetPassword'])->name('password.reset.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'not_blocked'])->group(function () {
    Route::middleware('role:customer')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

    Route::middleware('role:customer')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.store');
        Route::post('/cart/buy-now/{product}', [CartController::class, 'buyNow'])->name('cart.buy_now');
        Route::post('/cart/remove/{item}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/add/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
        Route::post('/wishlist/remove/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/products/{id}/reviews', [ProductController::class, 'storeReview'])->name('products.reviews.store');
        Route::get('/messages/product/{product}', [MessageController::class, 'indexForProduct'])->name('messages.product');
    });

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    Route::prefix('seller')->middleware('role:seller')->group(function () {
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('seller.dashboard');
        Route::get('/profile/edit', [SellerDashboardController::class, 'editProfile'])->name('seller.profile.edit');
        Route::post('/profile/update', [SellerDashboardController::class, 'updateProfile'])->name('seller.profile.update');
        Route::get('/products', [SellerProductController::class, 'index'])->name('seller.products.index');
        Route::get('/products/create', [SellerProductController::class, 'create'])->name('seller.products.create');
        Route::post('/products', [SellerProductController::class, 'store'])->name('seller.products.store');
        Route::get('/products/{id}/edit', [SellerProductController::class, 'edit'])->name('seller.products.edit');
        Route::put('/products/{id}', [SellerProductController::class, 'update'])->name('seller.products.update');
        Route::delete('/products/{id}', [SellerProductController::class, 'destroy'])->name('seller.products.destroy');
        Route::get('/orders', [SellerDashboardController::class, 'orders'])->name('seller.orders');
        Route::post('/orders/{item}/status', [SellerDashboardController::class, 'updateOrderStatus'])->name('seller.orders.status');
        Route::get('/messages', [SellerDashboardController::class, 'messages'])->name('seller.messages');
        Route::get('/notifications', [NotificationController::class, 'sellerIndex'])->name('seller.notifications');
        Route::get('/withdrawals', [SellerWithdrawalController::class, 'index'])->name('seller.withdrawals');
        Route::post('/withdrawals', [SellerWithdrawalController::class, 'store'])->name('seller.withdrawals.store');
    });

    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::post('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.delete');
        Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.delete');
        Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('admin.orders');
        Route::get('/messages', [MessageController::class, 'adminMessages'])->name('admin.messages');
        Route::get('/notifications', [NotificationController::class, 'adminIndex'])->name('admin.notifications');
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.delete');
        Route::get('/withdrawals', [AdminWithdrawalController::class, 'index'])->name('admin.withdrawals');
        Route::post('/withdrawals', [AdminWithdrawalController::class, 'store'])->name('admin.withdrawals.store');
        Route::post('/withdrawals/{withdrawal}/approve', [AdminWithdrawalController::class, 'approve'])->name('admin.withdrawals.approve');
        Route::post('/withdrawals/{withdrawal}/reject', [AdminWithdrawalController::class, 'reject'])->name('admin.withdrawals.reject');
    });
});
