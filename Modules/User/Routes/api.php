<?php

use Illuminate\Http\Request;
use Modules\User\Http\Controllers\ApiUserController;
use Modules\User\Http\Controllers\ProfileController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/createdue', 'ApiUserController@createdue');
Route::prefix('vendor')->name('api.')->group(function(){
    Route::get('/', 'ApiUserController@index')->name('vendor')->middleware('auth:api');
    Route::post('/login','VendorLoginController@login')->name('login')->middleware('guest');
    Route::post('/register','VendorRegistrationController@register')->name('register')->middleware('guest');

    Route::get('getVendorFromID/{id}', 'ApiUserController@getVendorFromID')->middleware('auth:api')->name('getVendorFromID');
    
    Route::put('updateVendor/{id}', 'ApiUserController@updateVendor')->middleware('auth:api')->name('updateVendor');
    Route::delete('deleteVendor', 'ApiUserController@deleteVendor')->name('deleteVendor');
    Route::post('verification-code/{code}','ApiUserController@verifificationCode')->name('verifificationCode');
    Route::post('send-email-link', 'ApiUserController@sendEmailLink')->name('sendEmailLink');

    Route::post('reset-password', 'ApiUserController@resetPassword')->name('passwordResetForm');
    Route::post('update-password', 'ApiUserController@updatePassword')->name('updatePassword');
    Route::post('change-password', 'ApiUserController@changePassword')->name('changePassword');
    });

    Route::prefix('user')->name('api.')->group(function(){
        Route::post('/login','UserController@login'); // DUPLICATE ->name('login');
        Route::post('/register', 'UserController@register'); // DUPLICATE ->name('register');
    
        Route::post('verification-code/{code}','UserController@verifificationCode'); // Duplicate ->name('verifificationCode');
        Route::post('send-email-link', 'UserController@sendEmailLink'); // Duplicate ->name('sendEmailLink');
        Route::post('reset-password', 'ApiUserController@resetPassword'); // DUPLICATE ->name('passwordResetForm');
        Route::post('update-password', 'UserController@updatePassword'); // DuPLICATE->name('updatePassword');
        Route::post('change-password', 'UserController@changePassword')->middleware('auth:api'); // DuPLICATE ->name('changePassword');
        Route::get('fetch-user-profile/{user}', 'ProfileController@edit')->middleware('auth:api')->name('editUserProfile');
        Route::put('edit-user-profile/{user}', 'ProfileController@update')->middleware('auth:api')->name('updateUserProfile');
        Route::post('update-user-image/{user}', 'ProfileController@updateImage')->middleware('auth:api')->name('updateUserImage');
        Route::get('show-user-image/{user}', 'ProfileController@profileImage')->middleware('auth:api')->name('profileImage');
        Route::put('edit-address/{user}', 'ProfileController@editAddress')->middleware('auth:api')->name('editAddress');
        });

        Route::post('changeVendorStatus', 'ApiUserController@changeVendorStatus')->name('api.changeVendorStatus');
        Route::post('getVendorStatus', 'ApiUserController@getVendorStatus')->name('api.getVendorStatus');

Route::put('vendors/{vendor}/feature', 'VendorFeatureController@store')->name('api.vendor.feature');
Route::delete('vendors/{vendor}/notfeature', 'VendorFeatureController@destroy')->name('api.vendor.notfeature');