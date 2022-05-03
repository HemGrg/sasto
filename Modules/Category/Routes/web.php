<?php

use Modules\Category\Http\Controllers\CategoryController;

Route::prefix('category')->group(function() {
    // Route::get('/', 'CategoryController@index');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:super_admin|admin|vendor']], function () {
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::get('/category/view/{id}', [CategoryController::class, 'view'])->name('category.view');
});
