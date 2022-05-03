<?php

use Illuminate\Support\Facades\Route;
use Modules\Message\Http\Controllers\ChatRoomController;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/chat', [ChatRoomController::class, 'index']);
    Route::get('/chat/{chatRoom}', [ChatRoomController::class, 'show'])->name('chatroom.show');
});
