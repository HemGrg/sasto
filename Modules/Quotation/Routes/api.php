<?php

use Illuminate\Support\Facades\Route;
use Modules\Quotation\Http\Controllers\QuotationApiController;
use Modules\Quotation\Http\Controllers\QuotationController;

Route::group(['middleware' => 'auth:api'],  function () {
    Route::get('quotations', [QuotationApiController::class, 'index']);
    Route::get('quotations/{quotation}', [QuotationApiController::class, 'show']);
    Route::post('quotation', [QuotationController::class, 'store'])->name('quotations.store');
});
