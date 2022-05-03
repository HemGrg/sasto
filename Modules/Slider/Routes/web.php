<?php


Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::resource('slider', 'SliderController');
});

