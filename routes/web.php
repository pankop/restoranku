<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return redirect()->route('menu');
});
Route::get('/customer/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/customer/cart', [MenuController::class, 'cart'])->name('cart');
Route::post('/customer/cart/add', [MenuController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [MenuController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [MenuController::class, 'removeCart'])->name('cart.remove');
Route::get('/cart/clear', [MenuController::class, 'clearCart'])->name('cart.clear');

Route::get('/customer/checkout', [MenuController::class, 'checkout'])->name('checkout');
Route::post('/customer/checkout/store', [MenuController::class, 'storeOrder'])->name('checkout.store');
Route::get('/checkout/success/{orderId}', [MenuController::class, 'checkoutSuccess'])->name('checkout.success');

