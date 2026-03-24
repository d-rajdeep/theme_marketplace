<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontendDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;


// ─── Admin Routes ────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Products
    Route::resource('products', ProductController::class);

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status/{status}', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// ─── Public Routes ───────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// All products
Route::get('/products', [HomeController::class, 'allProducts'])->name('products.all');
// Single Product Page
Route::get('/product/{category_slug}/{product_slug}', [HomeController::class, 'show'])->name('product.show');


// Shopping Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// ─── Guest Only Routes ───────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ─── Authenticated User Routes ───────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [FrontendDashboardController::class, 'index'])->name('dashboard');

    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // Checkout & Payment Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/download/{itemId}', [CheckoutController::class, 'download'])->name('product.download');
});
