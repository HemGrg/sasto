<?php
use Modules\Brand\Http\Controllers\BrandController;

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

Route::prefix('brand')->group(function() {
    // Route::get('/', 'BrandController@index');
});
Route::group(['prefix' => 'admin', 'middleware' => ['auth','Admin']], function () {
    Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
    Route::get('/brand/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
    Route::get('/brand/view/{id}', [BrandController::class, 'view'])->name('brand.view');
});
