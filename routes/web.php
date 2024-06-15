<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/Products', [ProductsController::class, 'index'])->name('products-view');
Route::get('/Products/Product/{product}', [ProductsController::class, 'show'])->name('product-view');
Route::post('/Products/Ordersession', [OrdersController::class, 'orderSession'])->name('create-order-session');
Route::post('/Products/Order/RemoveFromCart', [OrdersController::class, 'removeCartItem'])->name('remove-item-from-cart');
Route::post('/Products/Order/ChangeUserStock', [OrdersController::class, 'changeUserStock'])->name('change-order-user-selected-stock');
Route::post('/Products/Order/OrderPayment', [OrdersController::class, 'OrderPayment'])->name('order-payment');
Route::get('/Products/Orders', [OrdersController::class, 'index'])->name('orders-view');
Route::post('/Product/saveToCart', [CartController::class, 'store'])->name('add-to-cart');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
