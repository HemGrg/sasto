<?php

Route::group(['middleware' => ['auth', 'role:super_admin|admin'],'prefix'=>'admin'], function () {
    Route::resource('partner', PartnerController::class);
    Route::resource('partner-type', PartnerTypeController::class);
    Route::get('partner-request', 'BecomePartnerController@index')->name('partner-request.index');
    Route::delete('partner-request/{partner}', 'BecomePartnerController@delete')->name('partner-request.destroy');
});
Route::post('view-partner-request','BecomePartnerController@viewPartnerRequest')->name('viewPartnerRequest');
