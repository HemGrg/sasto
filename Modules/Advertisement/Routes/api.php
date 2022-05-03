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

Route::middleware('auth:api')->get('/advertisement', function (Request $request) {
    return $request->user();
});
// Route::group([ 'middleware' => ['auth:api','Admin']], function () {
Route::post('/createadvertisement', 'AdvertisementController@createadvertisement');
Route::get('/alladvertisements', 'AdvertisementController@alladvertisements');
Route::post('/deleteadvertisement', 'AdvertisementController@deleteadvertisement')->name('api.deleteadvertisement');
// Route::post('/getadvertisementFromID', 'AdvertisementController@getadvertisementFromID');
Route::get('/view-advertisement', 'AdvertisementController@viewadvertisement')->name('viewadvertisement');
Route::get('/editadvertisement', 'AdvertisementController@editadvertisement')->name('editadvertisement');
Route::post('/updateadvertisement', 'AdvertisementController@updateadvertisement');
// });