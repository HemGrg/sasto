<?php

use Modules\Admin\Http\Controllers\AdminController;

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

Route::get('/admin/login', [AdminController::class, 'login'])->name('login')->middleware('guest');
Route::post('/admin/login', [AdminController::class, 'postLogin'])->name('postLogin')->middleware('guest');

// Route::post('/postLogin',[AdminController::class,'postLogin'])->name('postLogin');

Route::group(['namespace' => 'Admin', 'middleware' => ['auth'], 'prefix' => 'admin'], function () {
    // Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    Route::get('logout', [AdminController::class, 'admin__logout'])->name('admin.logout');
    Route::get('change-password', [AdminController::class, 'changePassword'])->name('change.password');
    Route::post('change-password', [AdminController::class, 'updatePassword'])->name('update.password');
});
