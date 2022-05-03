<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/subcategory', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/createsubcategory', 'SubcategoryController@store')->middleware('role:super_admin|admin|vendor');
    Route::get('/getcategory', 'SubcategoryController@getcategories')->middleware('role:super_admin|admin|vendor');
    Route::get('/getsubcategories', 'SubcategoryController@getsubcategories')->middleware('role:super_admin|admin|vendor');
    Route::delete('/deletesubcategory/{subcategory}', 'SubcategoryController@deletesubcategory')->name('api.deletesubcategory')->middleware('role:super_admin|admin');
    // Route::post('/getsubcategoryFromID', 'subcategoryController@getsubcategoryFromID');
    Route::get('/view-subcategory', 'SubcategoryController@viewsubcategory')->name('viewsubcategory');
    Route::get('/editsubcategory', 'SubcategoryController@editsubcategory')->name('editsubcategory');
    Route::post('/updatesubcategory', 'SubcategoryController@updatesubcategory')->middleware('role:super_admin|admin');
    
    Route::put('subcategory/{subcategory}/publish', 'SubcategoryPublicationController@store')->name('api.subcategory.publish')->middleware('role:super_admin|admin');
    Route::delete('subcategory/{subcategory}/unpublish', 'SubcategoryPublicationController@destroy')->name('api.subcategory.unpublish')->middleware('role:super_admin|admin');
});
