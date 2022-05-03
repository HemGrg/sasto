<?php

use Modules\Payment\Http\Controllers\TransactionController;

Route::group(['middleware' => 'auth'], function() {
    Route::get('transactions/{user}', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('transactions/record-payment/{vendorUserId}', [TransactionController::class, 'recordPayment'])->name('transactions.record-payment');
    Route::post('transactions/change-cod-transaction-status/{transaction}', [TransactionController::class, 'changeCodTransactionStatus'])->name('transactions.change-cod-transaction-status');
});
