<?php
use Modules\ProductAttribute\Http\Controllers\ProductAttributeController;
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

Route::prefix('productattribute')->group(function() {
    // Route::get('/', 'ProductAttributeController@index');
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/product/image/{id}', [ProductAttributeController::class, 'productImage'])->name('productattribute.image');

    Route::get('/productattribute', [ProductAttributeController::class, 'index'])->name('productattribute.index');
    Route::get('/productattribute/create', [ProductAttributeController::class, 'create'])->name('productattribute.create');
    Route::get('/productattribute/practise', [ProductAttributeController::class, 'practise'])->name('productattribute.practise');
    Route::get('/productattribute/edit/{id}', [ProductAttributeController::class, 'edit'])->name('productattribute.edit');
    Route::get('/productattribute/view/{id}', [ProductAttributeController::class, 'view'])->name('productattribute.view');
});

