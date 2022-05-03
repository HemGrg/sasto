<?php

use Modules\User\Http\Controllers\ApiUserController;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Controllers\VendorLoginController;

Route::post('/vendor/update-password', 'ApiUserController@updatePassword'); // DUPLICATE ->name('updatePassword');
Route::post('/vendor/login', [VendorLoginController::class, 'login'])->name('vendor.login');
Route::get('account-activate/{link}', [ApiUserController::class, 'verifyNewAccount'])->name('verifyNewAccount');
Route::get('reset-password/{token}', 'PasswordResetController@passwordResetForm')->name('passwordResetForm');
Route::group(['middleware' => ['auth', 'role:super_admin|admin'],'prefix'=>'admin','as'=>'vendor.'], function () {
    Route::get('approved-vendors', 'VendorManagementController@getApprovedVendors')->name('getApprovedVendors');
    Route::get('suspended-vendors', 'VendorManagementController@getSuspendedVendors')->name('getSuspendedVendors');
    Route::get('new-vendors', 'VendorManagementController@getNewVendors')->name('getNewVendors');
    Route::get('vendorprofile/{username}', 'VendorManagementController@getVendorProfile')->name('getVendorProfile');
    Route::post('update-vendor-details/{vendor}', 'VendorManagementController@updateVendorDetails')->name('updateVendorDetails');
    Route::post('update-vendor-desc/{vendor}', 'VendorManagementController@updateVendorDescription')->name('updateVendorDescription');
    Route::post('update-shipping-info/{vendor}', 'VendorManagementController@updateShippingInfo')->name('updateShippingInfo');
    Route::post('update-user-details/{vendor}', 'VendorManagementController@updateUserDetails')->name('updateUserDesc');
    Route::post('update-vendor-bank-details/{vendor}', 'VendorManagementController@updateVendorBankDetails')->name('updateVendorBankDetails');
    Route::get('products/{username}', 'VendorManagementController@getVendorProducts')->name('getVendorProducts');
    Route::post('update-commission', 'VendorManagementController@updateCommisson')->name('updateCommisson');
});

Route::group(['middleware' => ['auth', 'role:vendor'],'prefix'=>'vendor'], function () {
    Route::get('profile', 'VendorController@profile')->name('vendor.profile');
    Route::get('editprofile/{id}', 'VendorController@editVendorProfile')->name('editVendorProfile');
    Route::post('updateprofile/{id}', 'VendorController@updateVendorProfile')->name('updateVendorProfile');

    Route::get('report', 'VendorController@getVendorPaymentReport')->name('getVendorPaymentReport');
    Route::get('shipping-info', 'VendorShippingInfoController@create')->name('getShippingInfo');
    Route::post('update-shipping-info', 'VendorShippingInfoController@store')->name('updateShippingInfo');
});
Route::post('updatevendordesc/{id}', 'VendorController@updateVendorDesc')->name('updateVendorDesc');
Route::post('update-vendor-bank-details/{vendor}', 'VendorController@updateVendorBankDetails')->name('updateVendorBankDetails');
Route::post('update-user-details/{vendor}', 'VendorController@updateUserDetails')->name('updateUserDesc');


Route::group(['namespace' => 'User','as' => 'user.'], function () {
    Route::get('user-account-activate/{activation_token}', [UserController::class, 'verifyNewAccount'])->name('verifyNewAccount');
});

Route::group(['middleware' => ['auth', 'role:admin|super_admin'],'prefix'=>'admin'], function () {
    Route::get('/vendor/view/{id}', 'VendorController@view')->name('vendor.view');
});
