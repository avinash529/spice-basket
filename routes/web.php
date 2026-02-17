<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WholesaleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WholesaleContentController as AdminWholesaleContentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/products', [ShopController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ShopController::class, 'show'])->name('products.show');
Route::get('/spices-guide', [PageController::class, 'spicesGuide'])->name('spices.guide');
Route::get('/offers', [PageController::class, 'offers'])->name('offers.index');
Route::get('/gift-boxes', [PageController::class, 'giftBoxes'])->name('gift-boxes.index');
Route::get('/blog', [PageController::class, 'blog'])->name('blog.index');
Route::get('/corporate-gift-boxes', [PageController::class, 'corporateGiftBoxes'])->name('corporate-gifts.index');
Route::post('/corporate-gift-boxes/inquiry', [PageController::class, 'storeCorporateInquiry'])->name('corporate-gifts.inquiry');
Route::get('/shipping-policy', [PageController::class, 'shippingPolicy'])->name('policies.shipping');
Route::get('/refund-policy', [PageController::class, 'refundPolicy'])->name('policies.refund');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('policies.privacy');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('policies.terms');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [OrderController::class, 'index'])->name('dashboard');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::patch('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('wholesale')->name('wholesale.')->middleware(['auth', 'wholesale'])->group(function () {
    Route::get('/', [WholesaleController::class, 'index'])->name('index');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class)->except(['show', 'create', 'store']);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('wholesale-content', AdminWholesaleContentController::class)->except(['show']);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::post('products/{product}/stock', [AdminProductController::class, 'addStock'])->name('products.stock');
});

require __DIR__.'/auth.php';
