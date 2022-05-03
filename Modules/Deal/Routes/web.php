<?php

use Illuminate\Support\Facades\Route;
use Modules\Deal\Http\Controllers\DealController;
use Modules\Deal\Http\Controllers\SendDealController;

Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
    Route::get('deals', [DealController::class, 'index'])->name('deals.index');
    Route::get('deals/create', [DealController::class, 'create'])->name('deals.create')->middleware('role:vendor');
    Route::get('deals/{deal}', [DealController::class, 'show'])->name('deals.show');
    Route::get('deals/{deal}/edit', [DealController::class, 'edit'])->name('deals.edit');
    Route::get('send-del/{deal}', [SendDealController::class, 'send'])->name('send-deal');
});
