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

Route::middleware('auth:api')->get('/role', function (Request $request) {
    return $request->user();
});
// Route::group([ 'middleware' => ['auth:api','Admin']], function () {
Route::post('/createrole', 'RoleController@createrole');
Route::get('/getroles', 'RoleController@getroles');
Route::post('/deleterole', 'RoleController@deleterole')->name('api.deleteRole');
// Route::post('/getroleFromID', 'RoleController@getroleFromID');
Route::get('/view-role', 'RoleController@viewRole')->name('viewRole');
Route::get('/editrole', 'RoleController@editRole')->name('editRole');
Route::post('/updaterole', 'RoleController@updateRole');
// });


Route::group([ 'middleware' => ['auth:api']], function () {
    // Route::get('/getroles', 'RoleController@getroles');
    // Route::post('/createrole', 'RoleController@createrole');
    // Route::post('/editrole', 'RoleController@editrole');
    // Route::get('/getroleFromID', 'RoleController@getroleFromID');
    // Route::post('/deleterole', 'RoleController@deleterole');
});