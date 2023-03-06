<?php

use App\Helpers\Cart\Cart;
use App\Http\Controllers\CartController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Profile\OrderController;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use \Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile;
use Morilog\Jalali\Jalalian;

Route::get('/', [IndexController::class, 'index']);
Route::get('/test', function() {
    $module = \Module::find('Discount');
    $module->enable();
});

Auth::routes(['verify' => true]);
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'callback']);
Route::get('/auth/token', [App\Http\Controllers\Auth\AuthTokenController::class, 'getToken'])->name('2fa.token');
Route::post('/auth/token', [App\Http\Controllers\Auth\AuthTokenController::class, 'postToken']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/secret', function () {
    return 'secret';
})->middleware(['auth', 'password.confirm']);
Route::get('download/{user}/file', function($file) {
    return \Illuminate\Support\Facades\Storage::download(request('path'));
})->name('download.file')->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [Profile\IndexController::class, 'index'])->name('profile');
        Route::get('twofactor', [Profile\TwoFactorAuthController::class, 'manageTwoFactor'])->name('profile.2fa.manage');
        Route::post('twofactor', [Profile\TwoFactorAuthController::class, 'postManageTwoFactor']);

        Route::get('twofactor/phone', [Profile\TokenAuthController::class, 'getPhoneVerify'])->name('profile.2fa.phone');
        Route::post('twofactor/phone', [Profile\TokenAuthController::class, 'postPhoneVerify']);

        Route::get('orders', [OrderController::class, 'index'])->name('profile.orders');
        Route::get('orders/{order}', [OrderController::class, 'showDetails'])->name('profile.orders.detail');
        Route::get('orders/{order}/payment', [OrderController::class, 'payment'])->name('profile.orders.payment');
    });
    Route::post('comments', [HomeController::class, 'comment'])->name('send.comment');
    Route::post('payment', [PaymentController::class, 'payment'])->name('cart.payment');
    Route::get('payment', [PaymentController::class, 'payment'])->name('cart.payment');
    Route::get('payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
});

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'single']);
