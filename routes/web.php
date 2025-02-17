<?php

use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/client/profile', [ProfileController::class, 'showArtistProfile'])->name('artist.profile');
});

Route::get('/artwork/{artwork}', [HomeController::class, 'show_artwork'])->name('artwork.show');
Route::get('/service/{service}', [HomeController::class, 'show_service'])->name('service.show');

Route::post('/artwork/{artwork}', [OrderController::class, 'store'])->name('client.order.store');

require __DIR__ . '/auth.php';
require __DIR__ . '/artist.php';
require __DIR__ . '/admin.php';
