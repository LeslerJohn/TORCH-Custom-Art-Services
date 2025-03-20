<?php

use App\Http\Controllers\Admin\ArtistApplicationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;

Route::get('/admin', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');
Route::get('/admin/dashboard/export', [DashboardController::class, 'exportStatistics'])->name('admin.dashboard.export');
Route::get('/admin/dashboard/export-all', [DashboardController::class, 'exportAllStatistics'])->name('admin.dashboard.export-all');

Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category.index');
Route::get('/admin/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
Route::post('/admin/category', [CategoryController::class, 'store'])->name('admin.category.store');
Route::get('/admin/category/{category}', [CategoryController::class, 'show'])->name('admin.category.show');
Route::get('/admin/category/{category}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
Route::put('/admin/category/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
Route::delete('/admin/category/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

Route::post('/admin/category/{category}/tags', [CategoryController::class, 'addTag']);
Route::delete('/admin/category/{category}/tags/{tag}', [CategoryController::class, 'removeTag']);


Route::get('/admin/user', [UserManagementController::class, 'index'])->name('admin.user.index');
Route::get('/admin/user/{user}', [UserManagementController::class, 'show'])->name('admin.user.show');
Route::get('/admin/user/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.user.edit');
Route::put('/admin/user/{user}', [UserManagementController::class, 'update'])->name('admin.user.update');
Route::delete('/admin/user/{user}', [UserManagementController::class, 'destroy'])->name('admin.user.destroy');

Route::get('/admin/artist-application', [ArtistApplicationController::class, 'index'])->name('admin.application.index');
Route::get('/admin/artist-application/{application}', [ArtistApplicationController::class, 'show'])->name('admin.application.show');
Route::get('/admin/artist-application/{application}/approve', [ArtistApplicationController::class, 'approve'])->name('admin.application.approve');
Route::get('/admin/artist-application/{application}/reject', [ArtistApplicationController::class, 'reject'])->name('admin.application.reject');

Route::get('/admin/commission', [CommissionController::class, 'index'])->name('admin.commission.index');
Route::get('/admin/commission/{commission}', [CommissionController::class, 'show'])->name('admin.commission.show');
Route::get('/admin/commission/{commission}/refund', [CommissionController::class, 'refund'])->name('admin.commission.refund');
Route::get('/admin/commission/{commission}/cancel', [CommissionController::class, 'cancel'])->name('admin.commission.cancel');
Route::put('/admin/commission/{commission}/update-status', [CommissionController::class, 'updateStatus'])->name('admin.commission.updateStatus');
Route::put('/admin/commission/{commission}/update-delivery-status', [CommissionController::class, 'updateDeliveryStatus'])->name('admin.commission.updateDeliveryStatus');
Route::put('/admin/commission/{commission}/extend-deadline', [CommissionController::class, 'extendDeadline'])->name('admin.commission.extendDeadline');
Route::put('/admin/commission/{commission}/reject-extension', [CommissionController::class, 'rejectExtension'])->name('admin.commission.rejectExtension');
Route::patch('/admin/commission/{commission}/approve-refund', [CommissionController::class, 'approveRefund'])->name('admin.commission.approveRefund');
Route::patch('/admin/commission/{commission}/reject-refund', [CommissionController::class, 'rejectRefund'])->name('admin.commission.rejectRefund');

Route::get('/admin/report', [ReportController::class, 'index'])->name('admin.report.index');
Route::get('/admin/report/{report}', [ReportController::class, 'show'])->name('admin.report.show');

Route::get('/admin/order', [OrderController::class,'index'])->name('admin.order.index');
Route::get('/admin/order/{order}', [OrderController::class,'show'])->name('admin.order.show');
Route::get('/admin/order/{order}/cancel', [OrderController::class,'cancel'])->name('admin.order.cancel');
Route::get('/admin/order/{order}/return', [OrderController::class,'return'])->name('admin.order.return');
Route::put('/admin/order/{order}/update-status', [OrderController::class,'updateStatus'])->name('admin.order.updateStatus');
Route::put('/admin/order/{order}/update-delivery-status', [OrderController::class,'updateDeliveryStatus'])->name('admin.order.updateDeliveryStatus');
Route::patch('/admin/order/{order}/approve-refund', [OrderController::class,'approveRefund'])->name('admin.order.approveRefund');
Route::patch('/admin/order/{order}/reject-refund', [OrderController::class,'rejectRefund'])->name('admin.order.rejectRefund');
Route::get('/admin/order/{order}/deliver', [OrderController::class,'deliver'])->name('admin.order.deliver');
Route::get('/admin/order/{order}/delivered', [OrderController::class,'delivered'])->name('admin.order.delivered');