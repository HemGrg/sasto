<?php

use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\ProductImageController;
use Modules\Product\Http\Controllers\ProductStorageController;

Route::group(['middleware' => ['auth', 'role:super_admin|admin|vendor']], function () {
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/edit/{product}', [ProductStorageController::class, 'edit'])->name('product.edit');
    Route::get('/product/view/{id}', [ProductController::class, 'view'])->name('product.view');
    Route::get('/product-pricing/{product}', [ProductStorageController::class, 'pricing'])->name('product.pricing');
    Route::post('/product-pricing/{product}', [ProductStorageController::class, 'savePricing'])->name('product.pricing.store');
    Route::get('/product-images/{product}', [ProductImageController::class, 'index'])->name('product-images.index');
    Route::get('/product-images/{product}/listing', [ProductImageController::class, 'listing'])->name('ajax.product-images.listing');
    Route::post('/product-images', [ProductImageController::class, 'store'])->name('ajax.product-images.store');
    Route::delete('/product-images/{productImage}', [ProductImageController::class, 'destroy'])->name('ajax.product-images.destroy');
    
});

Route::group(['middleware' => ['auth', 'role:vendor']], function () {
    Route::get('/product/create', [ProductStorageController::class, 'create'])->name('product.create');

});
