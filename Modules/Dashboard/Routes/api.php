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

Route::middleware('auth:api')->get('/dashboard', function (Request $request) {
    return $request->user();
});
// Route::group([ 'middleware' => ['auth:api']], function () {
Route::post('salesSearchByDates', 'SalesReportController@salesSearchByDates');
// });

// Route::get('sales-report/weekly', 'SalesReportController@weekly_report')->name('weekly_report');
// Route::get('sales-report/daily', 'SalesReportController@daily_report')->name('daily_report');