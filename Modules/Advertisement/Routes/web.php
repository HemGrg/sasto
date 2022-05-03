<?php
use Modules\Advertisement\Http\Controllers\AdvertisementController;


Route::group(['middleware' => ['auth', 'role:super_admin|admin'],'prefix'=>'admin'], function () {
    Route::get('/advertisement', [AdvertisementController::class, 'index'])->name('advertisement.index');
    Route::get('/advertisement/create', [AdvertisementController::class, 'create'])->name('advertisement.create');
    Route::get('/advertisement/edit/{id}', [AdvertisementController::class, 'edit'])->name('advertisement.edit');
    Route::get('/advertisement/view/{id}', [AdvertisementController::class, 'view'])->name('advertisement.view');
});
