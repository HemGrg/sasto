<?php

use Modules\ProductCategory\Http\Controllers\ProductCategoryController;

Route::group(['prefix'=> 'product-category', 'middleware' => 'auth'], function() {
    Route::get('/', [ProductCategoryController::class, 'index'])->name('product-category.index');
    Route::get('/create', [ProductCategoryController::class, 'create'])->name('product-category.create');
    Route::post('/', [ProductCategoryController::class, 'store'])->name('product-category.store');
    Route::get('/{productCategory}/edit', [ProductCategoryController::class, 'edit'])->name('product-category.edit');
    Route::put('/{productCategory}', [ProductCategoryController::class, 'update'])->name('product-category.update');
    Route::delete('/{productCategory}', [ProductCategoryController::class, 'destroy'])->name('product-category.destroy');
});
