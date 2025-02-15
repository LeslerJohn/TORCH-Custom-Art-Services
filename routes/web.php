<?php

use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/artwork/{artwork}', [HomeController::class, 'show_artwork'])->name('artwork.show');
Route::get('/service/{service}', [HomeController::class, 'show_service'])->name('service.show');

Route::get('/cart', [CartController::class, 'index'])->name('client.cart.index');
Route::post('/cart/{artwork}', [CartController::class, 'store'])->name('client.cart.store');
Route::delete('/cart/{artwork}', [CartController::class, 'destroy'])->name('client.cart.remove');
Route::post('/cart/order', [CartController::class, 'order'])->name('client.cart.order');

Route::post('/artwork/{artwork}', [OrderController::class, 'store'])->name('client.order.store');
Route::get('/order', [OrderController::class, 'index'])->name('client.order.index');
Route::get('/order/{order}', [OrderController::class, 'show'])->name('client.order.show');
Route::patch('/order/{order}', [OrderController::class, 'update'])->name('client.order.update');
Route::delete('/order/{order}', [OrderController::class, 'destroy'])->name('client.order.destroy');

Route::get('/request', [RequestController::class, 'index'])->name('client.request.index');
Route::post('/request/{service}', [RequestController::class, 'store'])->name('client.request.store');


require __DIR__.'/auth.php';
require __DIR__.'/artist.php';
require __DIR__.'/admin.php';