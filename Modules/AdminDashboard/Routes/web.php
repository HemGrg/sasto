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


use Illuminate\Support\Facades\Route;
use Modules\AdminDashboard\Http\Controllers\AdminDashboardController;

Route::get('/dashboard',[AdminDashboardController::class,'dashboard'])->name('dashboard');
Route::match(['get','post'],'/login',[AdminDashboardController::class,'login'])->name('login');

Route::prefix("auth")->group(function(){
    Route::get('init','AdminDashboardController@init')->name('init');
    Route::post('post-login','AdminDashboardController@postLogin')->name('post-login');
    Route::post('register','AdminDashboardController@register')->name('register');
});





// Route::prefix('admindashboard')->group(function() {
//     Route::get('/', 'AdminDashboardController@index');
// });
