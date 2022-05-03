<?php

use Modules\Review\Http\Controllers\ReviewController;


Route::group(['middleware' => ['auth', 'role:super_admin|admin'],'prefix'=>'admin'], function () {
    Route::get('reviews',  [ReviewController::class, 'index'])->name('review.index');
});
