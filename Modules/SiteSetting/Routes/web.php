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


Route::resource('site-setting','SiteSettingController');

// Route::prefix('sitesetting')->group(function() {Route::prefix('sitesetting')->group(function() {
//     Route::get('sitesetting', 'SiteSettingController@index');
// });
