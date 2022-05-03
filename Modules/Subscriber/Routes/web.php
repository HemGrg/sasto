<?php
use Modules\Subscriber\Http\Controllers\SubscriberController;


Route::group(['middleware' => ['auth', 'role:super_admin|admin'],'prefix'=>'admin'], function () {
    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscriber.index');
    Route::get('/delete-subscriber/{subscriber}', [SubscriberController::class, 'delete'])->name('delete-subscriber');
});
