<?php

use Modules\Front\Http\Controllers\EsewaPaymentController;

Route::get('payment/esewa_success', [EsewaPaymentController::class, 'success'])->name('payment.esewa_success');
// Route::get('payment/esewa_failed', [EsewaPaymentController::class, 'failed'])->name('payment.esewa_failed');
