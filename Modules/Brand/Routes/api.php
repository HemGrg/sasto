<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/brand', function (Request $request) {
    return $request->user();
});
Route::group([ 'middleware' => ['auth:api','Admin']], function () {
Route::post('/createbrand', 'BrandController@createbrand');
Route::get('/getbrands', 'BrandController@getbrands');
Route::post('/deletebrand', 'BrandController@deletebrand')->name('api.deletebrand');
// Route::post('/getbrandFromID', 'brandController@getbrandFromID');
Route::get('/view-brand', 'BrandController@viewbrand')->name('viewbrand');
Route::get('/editbrand', 'BrandController@editbrand')->name('editbrand');
Route::post('/updatebrand', 'BrandController@updatebrand');
});