<?php

use Modules\AdminUser\Http\Controllers\AdminUserController;
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

Route::group(['middleware' => ['auth', 'role:super_admin|admin'],'prefix'=>'admin'], function () {
    Route::get('/vendors', [AdminUserController::class, 'index'])->name('user.index');
    Route::get('/customers', [AdminUserController::class, 'getAllCustomers'])->name('user.getAllCustomers');
});
