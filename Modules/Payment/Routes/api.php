<?php

use Modules\Payment\Http\Controllers\PaymentRequestController;

Route::post('/request-payment', [PaymentRequestController::class, 'requestPayment'] )->name('request-payment')->middleware('auth:api');
