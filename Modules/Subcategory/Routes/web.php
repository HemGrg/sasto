<?php

use Modules\Subcategory\Http\Controllers\SubcategoryController;

// Route::prefix('subcategory')->group(function() {
//     Route::get('/', 'SubcategoryController@index');
// });

Route::group(['prefix' => 'admin'], function () {
    Route::get('/subcategory', [SubcategoryController::class, 'index'])->name('subcategory.index')->middleware('role:super_admin|admin|vendor');
    Route::get('/subcategory/create', [SubcategoryController::class, 'create'])->name('subcategory.create')->middleware('role:super_admin|admin|vendor');
    Route::get('/subcategory/edit/{id}', [SubcategoryController::class, 'edit'])->name('subcategory.edit')->middleware('role:super_admin|admin');
    Route::get('/subcategory/view/{id}', [SubcategoryController::class, 'view'])->name('subcategory.view')->middleware('role:super_admin|admin|vendor');
});