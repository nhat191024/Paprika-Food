<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Livewire\Menu\MenuPage;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', MenuPage::class)->name('menu');

Route::post('locale', LocaleController::class)->name('locale.update');

Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::get('cart/summary', [CartController::class, 'summary'])->name('cart.summary');
Route::post('cart/items', [CartController::class, 'store'])->name('cart.items.store');
Route::patch('cart/items/{key}', [CartController::class, 'update'])->name('cart.items.update');
Route::delete('cart/items/{key}', [CartController::class, 'destroy'])->name('cart.items.destroy');
Route::get('checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::get('/{product_slug}/details', [ShopController::class, 'details'])->name('product.details');

require __DIR__.'/settings.php';
