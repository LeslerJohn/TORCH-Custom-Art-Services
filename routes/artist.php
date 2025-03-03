<?php

use App\Http\Controllers\Artist\ArtworkController;
use App\Http\Controllers\Artist\CommissionController;
use App\Http\Controllers\Artist\OrderController;
use App\Http\Controllers\Artist\ReviewController;
use App\Http\Controllers\Artist\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Artist\ShowcaseController;

Route::get('/artist', [App\Http\Controllers\Artist\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('artist.dashboard');

use Illuminate\Http\Request;
use App\Models\Tag;

Route::get('/get-tags/{categoryId}', function ($categoryId) {
    $tags = Tag::whereIn('id', function($query) use ($categoryId) {
        $query->select('tag_id')
            ->from('category_tag')
            ->where('category_id', $categoryId);
    })->get();
    return response()->json($tags);
});

Route::post('/artist/availability', [App\Http\Controllers\Artist\DashboardController::class, 'availability'])->middleware(['auth', 'verified'])->name('artist.availability');

// Showcase Routes
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/artist/showcase', 'App\Http\Controllers\Artist\ShowcaseController@index')->name('artist.showcase.index');
//     Route::get('/artist/showcase/create', 'App\Http\Controllers\Artist\ShowcaseController@create')->name('artist.showcase.create');
//     Route::post('/artist/showcase', 'App\Http\Controllers\Artist\ShowcaseController@store')->name('artist.showcase.store');
//     Route::get('/artist/showcase/{showcase}', 'App\Http\Controllers\Artist\ShowcaseController@show')->name('artist.showcase.show');
//     Route::get('/artist/showcase/{showcase}/edit', 'App\Http\Controllers\Artist\ShowcaseController@edit')->name('artist.showcase.edit');
//     Route::put('/artist/showcase/{showcase}', 'App\Http\Controllers\Artist\ShowcaseController@update')->name('artist.showcase.update');
//     Route::delete('/artist/showcase/{showcase}', 'App\Http\Controllers\Artist\ShowcaseController@destroy')->name('artist.showcase.destroy');
// });

// Route::resource('artist/showcase', ShowcaseController::class)->middleware(['auth', 'verified']);

// Service Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/artist/service', [ServiceController::class, 'index'])->name('artist.service.index');
    Route::get('/artist/service/create', [ServiceController::class, 'create'])->name('artist.service.create');
    Route::post('/artist/service', [ServiceController::class, 'store'])->name('artist.service.store');
    Route::get('/artist/service/{service}', [ServiceController::class, 'show'])->name('artist.service.show');
    Route::get('/artist/service/{service}/edit', [ServiceController::class, 'edit'])->name('artist.service.edit');
    Route::put('/artist/service/{service}', [ServiceController::class, 'update'])->name('artist.service.update');
    Route::delete('/artist/service/{service}', [ServiceController::class, 'destroy'])->name('artist.service.destroy');
});

// Route::resource('artist/artwork', ArtworkController::class)->middleware(['auth', 'verified']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/artist/artwork', [ArtworkController::class, 'index'])->name('artist.artwork.index');
    Route::get('/artist/artwork/create', [ArtworkController::class, 'create'])->name('artist.artwork.create');
    Route::post('/artist/artwork', [ArtworkController::class, 'store'])->name('artist.artwork.store');
    Route::get('/artist/artwork/{artwork}', [ArtworkController::class, 'show'])->name('artist.artwork.show');
    Route::get('/artist/artwork/{artwork}/edit', [ArtworkController::class, 'edit'])->name('artist.artwork.edit');
    Route::put('/artist/artwork/{artwork}', [ArtworkController::class, 'update'])->name('artist.artwork.update');
    Route::delete('/artist/artwork/{artwork}', [ArtworkController::class, 'destroy'])->name('artist.artwork.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/artist/order', [OrderController::class, 'index'])->name('artist.order.index');
    Route::get('/artist/order/create', [OrderController::class, 'create'])->name('artist.order.create');
    Route::post('/artist/order', [OrderController::class, 'store'])->name('artist.order.store');
    Route::get('/artist/order/{order}', [OrderController::class, 'show'])->name('artist.order.show');
    Route::post('/artist/order/{order}/deliver', [OrderController::class, 'deliver'])->name('artist.order.deliver');
    Route::post('/artist/order/{order}/delivered', [OrderController::class, 'delivered'])->name('artist.order.delivered');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/artist/commission', [CommissionController::class, 'index'])->name('artist.commission.index');
    Route::get('/artist/request/{request}', [CommissionController::class, 'showRequest'])->name('artist.request.show');
    Route::post('/artist/request/{request}/accept', [CommissionController::class, 'accept'])->name('artist.request.accept');
    Route::post('/artist/request/{request}/reject', [CommissionController::class, 'reject'])->name('artist.request.reject');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/artist/commission/{commission}', [CommissionController::class, 'show'])->name('artist.commission.show');
    Route::post('/artist/commission/{commission}/start', [CommissionController::class, 'start'])->name('artist.commission.start');
    Route::post('/artist/commission/{commission}/done', [CommissionController::class, 'done'])->name('artist.commission.done');
    Route::post('/artist/commission/{commission}/deliver', [CommissionController::class, 'deliver'])->name('artist.commission.deliver');
    Route::post('/artist/commission/{commission}/delivered', [CommissionController::class, 'delivered'])->name('artist.commission.delivered');
    Route::post('/artist/commission/{commission}/draft', [CommissionController::class, 'draft'])->name('artist.commission.draft');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/artist/review', [ReviewController::class, 'index'])->name('artist.review.index');
});