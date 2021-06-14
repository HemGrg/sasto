<?php

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

Route::prefix('api')->group(function () {
    Route::resource('category', 'CategoryController');
    Route::match(['get', 'post'], 'add-sub-category/{slug}', 'SubCategoryController@addSubCategory')->name('add-sub-category');
    Route::get('view-sub-categories/{slug}', 'SubCategoryController@viewSubCategories')->name('view-sub-categories');
    Route::match(['get', 'post'], 'edit-sub-category/{slug}', 'SubCategoryController@editSubCategory')->name('edit-sub-category');
    Route::match(['get', 'post'], 'delete-sub-category/{id}', 'SubCategoryController@deleteSubCat')->name('delete-sub-category');
});

// Route::prefix('category')->group(function() {
//     Route::get('/', 'CategoryController@index');
// });
