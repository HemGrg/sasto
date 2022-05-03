<?php

use Modules\Order\Http\Controllers\OrderController;
use Modules\Order\Http\Controllers\PackageController;

Route::group(['middleware' => ['auth', 'role:super_admin|admin|vendor']], function () {
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    // Route::put('orders/packages/{package}/update', [PackageController::class, 'update'])->name('orders.package.update');
});