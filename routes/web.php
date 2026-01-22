<?php

use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ReviewController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Artist\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Static Pages
Route::get('/about us', function () {
    return view('statics/about');
})->name('about');
Route::get('/terms & conditions', function () {
    return view('statics/terms');
})->name('terms');
Route::get('/privacy policy', function () {
    return view('statics/privacy');
})->name('privacy');
Route::get('/artist-agreement', function () {
    return view('statics/artist-agreement');
})->name('artist-agreement');
Route::get('/client-agreement', function () {
    return view('statics/client-agreement');
})->name('client-agreement');

Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [HomeController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/address/{user}', [ProfileController::class, 'storeAddress'])->name('address.store');
    Route::put('/profile/address', [ProfileController::class, 'updateAddress'])->name('address.update');
    Route::get('/client/profile', [ProfileController::class, 'showClientProfile'])->name('client.profile');
    Route::put('/profile/payment-method', [ProfileController::class, 'updatePaymentMethod'])->name('profile.update-payment-method');
});

Route::get('/artist/profile/{artist}', [ProfileController::class, 'showArtistProfile'])->name('artist.profile');
Route::get('/client/artist', [HomeController::class, 'artist'])->name('client.artist');
Route::get('/client/artwork', [HomeController::class, 'artwork'])->name('client.artwork');
Route::get('/client/service', [HomeController::class, 'service'])->name('client.service');
Route::get('/artwork/{artwork}', [HomeController::class, 'show_artwork'])->name('artwork.show');
Route::get('/service/{service}', [HomeController::class, 'show_service'])->name('service.show');

Route::middleware('auth')->group(function () {
    Route::put('/artwork/{artwork}/like', [ArtworkController::class, 'like'])->name('artwork.like');
    Route::delete('/artwork/{artwork}/unlike', [ArtworkController::class, 'unlike'])->name('artwork.unlike');
});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('client.cart.index');
    Route::post('/cart/{artwork}', [CartController::class, 'store'])->name('client.cart.store');
    Route::delete('/cart/remove/{artwork}', [CartController::class, 'destroy'])->name('client.cart.destroy');
    Route::post('/cart/checkout/{cart}', [CartController::class, 'checkout'])->name('client.cart.checkout');
    Route::get('/cart/checkout/success/{selected_items}', [CartController::class, 'success'])->name('client.cart.success');
});

Route::middleware('auth')->group(function () {
    Route::post('/artwork/{artwork}', [OrderController::class, 'store'])->name('client.order.store');
    Route::get('/order/success/{artwork}', [OrderController::class, 'success'])->name('client.order.success');
    Route::get('/order', [OrderController::class, 'index'])->name('client.order.index');
    Route::get('/order/{order}', [OrderController::class, 'show'])->name('client.order.show');
    Route::put('/order/{order}', [OrderController::class, 'update'])->name('client.order.update');
    Route::patch('/order/{order}', [OrderController::class, 'cancel'])->name('client.order.cancel');
    Route::post('/order/{order}/return', [OrderController::class, 'return'])->name('client.return.order');

    Route::post('/order/{order}/review', [ReviewController::class, 'order'])->name('client.review.order');
    Route::post('/commission/{commission}/review', [ReviewController::class, 'commission'])->name('client.review.commission');

    Route::get('/request', [RequestController::class, 'index'])->name('client.request.index');
    Route::post('/request/{service}', [RequestController::class, 'store'])->name('client.request.store');
    Route::get('/request/success/{requestData}/{service}', [RequestController::class, 'success'])->name('client.request.success');
    Route::get('/request/{request}', [RequestController::class, 'show'])->name('client.request.show');
    Route::patch('/request/{request}', [RequestController::class, 'update'])->name('client.request.update');
    Route::delete('/request/{request}', [RequestController::class, 'destroy'])->name('client.request.destroy');

    Route::post('/commission/{modelrequest}', [CommissionController::class, 'store'])->name('client.commission.store');
    Route::get('/commission', [CommissionController::class, 'index'])->name('client.commission.index');
    Route::get('/commission/{commission}', [CommissionController::class, 'show'])->name('client.commission.show');
    Route::post('/commission/{commission}/receive', [CommissionController::class, 'receive'])->name('client.commission.receive');
    Route::post('/commission/{commission}/return', [CommissionController::class, 'return'])->name('client.return.commission');
});

Route::get('mail/{name}', function ($name) {
    Mail::to('leslerjohngantalao@gmail.com')->send(new TestMail($name));
});

Route::get('auth/google', [GoogleController::class, 'googlePage'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'googleCallback'])->name('auth.google.callback');



require __DIR__ . '/auth.php';
require __DIR__ . '/artist.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/api.php';