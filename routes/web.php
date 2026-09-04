<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products & Catalog
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/api/products/autocomplete', [ProductController::class, 'searchSuggestions'])->name('products.search_suggestions');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

// Guest Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Authenticated Customer Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Customer Portal / Dashboard
    Route::get('/account/dashboard', [CustomerDashboardController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/account/profile', [CustomerDashboardController::class, 'profile'])->name('customer.profile');
    Route::put('/account/profile', [CustomerDashboardController::class, 'updateProfile'])->name('customer.profile.update');
    
    // Address Book
    Route::get('/account/addresses', [CustomerDashboardController::class, 'addresses'])->name('customer.addresses');
    Route::post('/account/addresses', [CustomerDashboardController::class, 'storeAddress'])->name('customer.addresses.store');
    Route::delete('/account/addresses/{id}', [CustomerDashboardController::class, 'destroyAddress'])->name('customer.addresses.destroy');

    // Wishlist
    Route::get('/account/wishlist', [CustomerDashboardController::class, 'wishlist'])->name('customer.wishlist');
    Route::post('/account/wishlist/toggle', [CustomerDashboardController::class, 'toggleWishlist'])->name('customer.wishlist.toggle');

    // Orders
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [CustomerOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/upload-proof', [CustomerOrderController::class, 'uploadPaymentProof'])->name('orders.upload_proof');
    Route::post('/orders/{id}/cancel', [CustomerOrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{id}/invoice', [CustomerOrderController::class, 'printInvoice'])->name('orders.invoice');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin Products CRUD
    Route::resource('products', AdminProductController::class);

    // Admin Categories CRUD
    Route::resource('categories', AdminCategoryController::class);

    // Admin Orders Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update_status');
});
