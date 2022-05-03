<?php

use Illuminate\Http\Request;
use Modules\Country\Http\Controllers\ApiCountryController;

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

Route::middleware('auth:api')->get('/country', function (Request $request) {
    return $request->user();
});
Route::get('countries', [ApiCountryController::class,'index'])->name('api.countries.index');
Route::get('countries/{country:slug}', [ApiCountryController::class,'show'])->name('api.countries.show');