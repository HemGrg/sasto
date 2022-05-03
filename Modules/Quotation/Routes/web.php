<?php

use Illuminate\Support\Facades\Route;
use Modules\Quotation\Http\Controllers\QuotationController;
use Modules\Quotation\Http\Controllers\QuotationReplyController;

Route::group(['middleware' => ['auth']], function () {
    Route::get('quotations', [QuotationController::class, 'index'])->name('quotations.index');
    Route::get('quotations/{quotation}', [QuotationController::class, 'show'])->name('quotations.show');
    Route::delete('quotations/{quotation}/destroy-for-vendor', [QuotationController::class, 'destroyForVendor'])->name('quotations.destroy-for-vendor');
    Route::delete('quotations/{quotation}', [QuotationController::class, 'destroy'])->name('quotations.destroy');

    Route::post('quotations-reply/{quotation}', [QuotationReplyController::class, 'store'])->name('quotations-reply.store');
});
