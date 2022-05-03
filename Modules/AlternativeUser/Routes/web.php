<?php

use Modules\AlternativeUser\Http\Controllers\AlternativeUserController;

Route::group(['middleware' => 'role:vendor'], function() {
    Route::get('alternative-users', [AlternativeUserController::class, 'index'])->name('alternative-users.index');
    Route::get('alternative-users/create', [AlternativeUserController::class, 'create'])->name('alternative-users.create');
    Route::post('alternative-users', [AlternativeUserController::class, 'store'])->name('alternative-users.store');
    Route::get('alternative-users/{alternativeUser}/edit', [AlternativeUserController::class, 'edit'])->name('alternative-users.edit');
    Route::put('alternative-users/{alternativeUser}', [AlternativeUserController::class, 'update'])->name('alternative-users.update');
    Route::delete('alternative-users/{alternativeUser}', [AlternativeUserController::class, 'destroy'])->name('alternative-users.destroy');
});
