<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Deal\Http\Controllers\DealApiController;
use Modules\Deal\Http\Controllers\DealController;

Route::middleware('auth:api')->get('/deal', function (Request $request) {
    return $request->user();
});
// Route::delete('/deleteproduct', [DealController::class,'destroy'])->name('api.deletedeal');
// Route::put('/updateproduct', [DealController::class,'update'])->name('api.updatedeal');
// Route::post('/deal/storeproduct', [DealController::class,'store'])->name('api.storedeal');
Route::delete('/deals/{deal}', [DealController::class, 'destroy'])->name('api.deletedeal');
Route::put('/deals/{id}', [DealController::class, 'update'])->name('api.updatedeal');
Route::post('/deals', [DealController::class, 'store'])->name('api.storedeal');

Route::get('deals/customer-search', [DealApiController::class, 'customerSearch']);
Route::get('deals/product-search', [DealApiController::class, 'productSearch'])->name('api.productsearch');

Route::get('deals/', [DealApiController::class, 'index'])->middleware('auth:api');
Route::get('deals/{deal}', [DealApiController::class, 'show'])->name('api.deals.show')->middleware('auth:api');
Route::get('editdeals/{deal}', [DealController::class, 'editDeal'])->name('api.deals.editDeal');
