<?php

use Illuminate\Http\Request;


Route::post('/createorder', 'OrderController@createorder');
Route::get('/getorders', 'OrderController@getorders');
Route::post('/changeOrderStatus', 'OrderController@changeOrderStatus')->name('api.changeOrderStatus');
Route::get('/editorder', 'OrderController@editorder')->name('editorder');

