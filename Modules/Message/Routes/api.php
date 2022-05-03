<?php

use Illuminate\Support\Facades\Route;
use Modules\Message\Http\Controllers\ChatRoomApiController;
use Modules\Message\Http\Controllers\MessageController;

Route::middleware('auth:api')->group(function () {
    Route::get('chatrooms', [ChatRoomApiController::class, 'index']);
    Route::get('chats/start', [ChatRoomApiController::class, 'start']);
    Route::get('chats/{chatRoom}', [ChatRoomApiController::class, 'show']);
    Route::delete('chats/{chatRoom}', [ChatRoomApiController::class, 'destroy']);

    Route::get('chats/{chatRoomId}/messages', [MessageController::class, 'index']);
    Route::post('messages/{chatRoom}', [MessageController::class, 'store']);
    Route::delete('messages', [MessageController::class, 'destroy']);

    Route::post('mark-seen-messages', [MessageController::class, 'markSeen']);

    Route::get('chat-customer-info/{user}', [ChatRoomApiController::class, 'customerInfo']);
});
