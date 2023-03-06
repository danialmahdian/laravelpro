<?php

use Modules\Main\Http\Controllers\Admin\ModuleController;

Route::get('modules', [ModuleController::class, 'index'])->name('modules.index');
Route::patch('modules/{module}/disable', [ModuleController::class, 'disable'])->name('modules.disable');
Route::patch('modules/{module}/enable', [ModuleController::class, 'enable'])->name('modules.enable');
