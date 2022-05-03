<?php

use Modules\Offer\Http\Controllers\OfferController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('offer')->group(function() {
    // Route::get('/', 'OfferController@index');
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth','Admin']], function () {
    Route::get('/offer', [OfferController::class, 'index'])->name('offer.index');
    Route::get('/offer/create', [OfferController::class, 'create'])->name('offer.create');
    Route::get('/offer/edit/{id}', [OfferController::class, 'edit'])->name('offer.edit');
    Route::get('/offer/view/{id}', [OfferController::class, 'view'])->name('offer.view');
});
