<?php

use Modules\Dashboard\Http\Controllers\DashboardController;
use Modules\Dashboard\Http\Controllers\SalesReportController;

Route::group(['middleware' => ['auth', 'role:super_admin|admin|vendor']], function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('sales-report' , [SalesReportController::class, 'getOrderInfo'])->middleware('auth')->name('salesReport');


