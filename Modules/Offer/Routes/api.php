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

Route::middleware('auth:api')->get('/offer', function (Request $request) {
    return $request->user();
});
Route::group([ 'middleware' => ['auth:api','Admin']], function () {
Route::post('/createoffer', 'OfferController@createoffer');
// Route::get('/getoffers', 'OfferController@getoffers');
Route::get('/getoffer', 'OfferController@getoffer');
Route::post('/deleteoffer', 'OfferController@deleteoffer')->name('api.deleteoffer');
// Route::post('/getofferFromID', 'offerController@getofferFromID');
Route::get('/view-offer', 'OfferController@viewoffer')->name('viewoffer');
Route::get('/editoffer', 'OfferController@editoffer')->name('editoffer');
Route::post('/updateoffer', 'OfferController@updateoffer');
});