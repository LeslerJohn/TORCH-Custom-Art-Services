<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CommissionController;
use App\Http\Controllers\admin\ReportController;

Route::get('/admin', 'App\Http\Controllers\Admin\DashBoardController@index')->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');

Route::get('/admin/category', 'App\Http\Controllers\Admin\CategoryController@index')->name('admin.category.index');
Route::get('/admin/category/create', 'App\Http\Controllers\Admin\CategoryController@create')->name('admin.category.create');
Route::post('/admin/category', 'App\Http\Controllers\Admin\CategoryController@store')->name('admin.category.store');
Route::get('/admin/category/{category}', 'App\Http\Controllers\Admin\CategoryController@show')->name('admin.category.show');
Route::get('/admin/category/{category}/edit', 'App\Http\Controllers\Admin\CategoryController@edit')->name('admin.category.edit');
Route::put('/admin/category/{category}', 'App\Http\Controllers\Admin\CategoryController@update')->name('admin.category.update');
Route::delete('/admin/category/{category}', 'App\Http\Controllers\Admin\CategoryController@destroy')->name('admin.category.destroy');


Route::get('/admin/user', 'App\Http\Controllers\Admin\UserManagementController@index')->name('admin.user.index');
Route::get('/admin/user/create', 'App\Http\Controllers\Admin\UserManagementController@create')->name('admin.user.create');
Route::post('/admin/user', 'App\Http\Controllers\Admin\UserManagementController@store')->name('admin.user.store');
Route::get('/admin/user/{user}', 'App\Http\Controllers\Admin\UserManagementController@show')->name('admin.user.show');
Route::get('/admin/user/{user}/edit', 'App\Http\Controllers\Admin\UserManagementController@edit')->name('admin.user.edit');
Route::put('/admin/user/{user}', 'App\Http\Controllers\Admin\UserManagementController@update')->name('admin.user.update');
Route::delete('/admin/user/{user}', 'App\Http\Controllers\Admin\UserManagementController@destroy')->name('admin.user.destroy');

Route::get('/admin/artist-application', 'App\Http\Controllers\Admin\ArtistApplicationController@index')->name('admin.application.index');
Route::get('/admin/artist-application/{artistApplication}', 'App\Http\Controllers\Admin\ArtistApplicationController@show')->name('admin.application.show');
Route::get('/admin/artist-application/{artistApplication}/approve', 'App\Http\Controllers\Admin\ArtistApplicationController@approve')->name('admin.application.approve');
Route::get('/admin/artist-application/{artistApplication}/reject', 'App\Http\Controllers\Admin\ArtistApplicationController@reject')->name('admin.application.reject');

Route::get('/admin/commission', [CommissionController::class, 'index'])->name('admin.commission.index');
Route::get('/admin/commission/{commission}', [CommissionController::class, 'show'])->name('admin.commission.show');
Route::get('/admin/commission/{commission}/refund', [CommissionController::class, 'refund'])->name('admin.commission.refund');
Route::get('/admin/commission/{commission}/cancel', [CommissionController::class, 'cancel'])->name('admin.commission.cancel');
Route::put('/admin/commission/{commission}/update-status', [CommissionController::class, 'updateStatus'])->name('admin.commission.updateStatus');
Route::put('/admin/commission/{commission}/update-delivery-status', [CommissionController::class, 'updateDeliveryStatus'])->name('admin.commission.updateDeliveryStatus');
Route::put('/admin/commission/{commission}/extend-deadline', [CommissionController::class, 'extendDeadline'])->name('admin.commission.extendDeadline');

Route::get('/admin/report', [ReportController::class, 'index'])->name('admin.report.index');
Route::get('/admin/report/{report}', [ReportController::class, 'show'])->name('admin.report.show');

Route::get('/admin/order', 'App\Http\Controllers\Admin\OrderController@index')->name('admin.order.index');
Route::get('/admin/order/{order}', 'App\Http\Controllers\Admin\OrderController@show')->name('admin.order.show');
Route::get('/admin/order/{order}/cancel', 'App\Http\Controllers\Admin\OrderController@cancel')->name('admin.order.cancel');
Route::get('/admin/order/{order}/return', 'App\Http\Controllers\Admin\OrderController@return')->name('admin.order.return');
Route::get('/admin/order/{order}/refund', 'App\Http\Controllers\Admin\OrderController@refund')->name('admin.order.refund');
Route::get('/admin/order/{order}/deliver', 'App\Http\Controllers\Admin\OrderController@deliver')->name('admin.order.deliver');
Route::get('/admin/order/{order}/delivered', 'App\Http\Controllers\Admin\OrderController@delivered')->name('admin.order.delivered');