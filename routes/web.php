<?php

use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/client/profile', [ProfileController::class, 'showClientProfile'])->name('client.profile');
    Route::get('/artist/profile/{artist}', [ProfileController::class, 'showArtistProfile'])->name('artist.profile');
});

Route::get('/client/artist', [HomeController::class, 'artist'])->name('client.artist');
Route::get('/client/artwork', [HomeController::class, 'artwork'])->name('client.artwork');
Route::get('/client/service', [HomeController::class, 'service'])->name('client.service');

Route::get('/artwork/{artwork}', [HomeController::class, 'show_artwork'])->name('artwork.show');
Route::get('/service/{service}', [HomeController::class, 'show_service'])->name('service.show');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('client.cart.index');
    Route::post('/cart/{artwork}', [CartController::class, 'store'])->name('client.cart.store');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('client.cart.destroy');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('client.cart.checkout');
});

Route::post('/artwork/{artwork}', [OrderController::class, 'store'])->name('client.order.store');
Route::get('/order', [OrderController::class, 'index'])->name('client.order.index');
Route::get('/order/{order}', [OrderController::class, 'show'])->name('client.order.show');
Route::patch('/order/{order}', [OrderController::class, 'update'])->name('client.order.update');
Route::delete('/order/{order}', [OrderController::class, 'destroy'])->name('client.order.destroy');

Route::post('/order/{order}/review', [ReviewController::class, 'order'])->name('client.review.order');
Route::post('/commission/{commission}/review', [ReviewController::class, 'commission'])->name('client.review.commission');

Route::get('/request', [RequestController::class, 'index'])->name('client.request.index');
Route::post('/request/{service}', [RequestController::class, 'store'])->name('client.request.store');
Route::get('/request/{request}', [RequestController::class, 'show'])->name('client.request.show');
Route::patch('/request/{request}', [RequestController::class, 'update'])->name('client.request.update');
Route::delete('/request/{request}', [RequestController::class, 'destroy'])->name('client.request.destroy');

Route::post('/commission/{modelrequest}', [CommissionController::class, 'store'])->name('client.commission.store');
Route::get('/commission', [CommissionController::class, 'index'])->name('client.commission.index');
Route::get('/commission/{commission}', [CommissionController::class, 'show'])->name('client.commission.show');
Route::post('/commission/{commission}/receive', [CommissionController::class, 'receive'])->name('client.commission.receive');

require __DIR__ . '/auth.php';
require __DIR__ . '/artist.php';
require __DIR__ . '/admin.php';
