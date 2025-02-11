<?php

use App\Http\Controllers\Artist\ArtworkController;
use App\Http\Controllers\Artist\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Artist\ShowcaseController;

Route::get('/artist', function () {
    return view('artist.dashboard');
})->middleware(['auth', 'verified'])->name('artist.dashboard');

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