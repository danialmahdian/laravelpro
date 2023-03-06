<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\User\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\User\UserController;

Route::get('/', function () {
    return view('admin.index');
})->name('index');

Route::resource('users', UserController::class);
Route::get('/users/{user}/permissions', [PermissionController::class, 'create'])->name('users.permissions')->middleware('can:staff-user-permissions');
Route::post('/users/{user}/permissions', [PermissionController::class, 'store'])->name('users.permissions.store')->middleware('can:staff-user-permissions');
Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
Route::resource('roles', RoleController::class);
Route::resource('products', ProductController::class)->except(['show']);
Route::resource('products.gallery', ProductGalleryController::class);

Route::post('attribute/values', [AttributeController::class, 'getValues']);

Route::resource('orders', OrderController::class);
Route::get('orders/{order}/orders', [OrderController::class, 'payments'])->name('orders.payments');

Route::get('comments/unapproved', [CommentController::class, 'unapproved'])->name('comments.unapproved');
Route::resource('comments', CommentController::class)->only(['index', 'update', 'destroy']);
Route::resource('categories', CategoryController::class);
