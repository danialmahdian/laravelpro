<?php


use Modules\Discount\Http\Controllers\Admin\DiscountController;

Route::resource('discount', DiscountController::class)->except(['show']);
