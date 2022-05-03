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

Route::middleware('auth:api')->get('/adminuser', function (Request $request) {
    return $request->user();
});
// Route::group([ 'middleware' => ['auth:api','Superadmin']], function () {
Route::post('/createuser', 'AdminUserController@createuser');
Route::get('/getusers', 'AdminUserController@getusers');
Route::post('/deleteuser', 'AdminUserController@deleteuser')->name('api.deleteuser');
// Route::post('/getuserFromID', 'AdminUserController@getuserFromID');
Route::get('/view-user', 'AdminUserController@viewuser')->name('viewuser');
Route::get('/edituser', 'AdminUserController@edituser')->name('edituser');
Route::post('/updateuser', 'AdminUserController@updateuser');
// });