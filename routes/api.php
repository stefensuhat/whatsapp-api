<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);

    // Chatroom routes
    Route::apiResource('chatrooms', ChatRoomController::class, ['only' => ['index', 'show', 'store']]);

    Route::prefix('chatrooms/{chatroom}')->group(function () {
        Route::post('/join', [ChatroomController::class, 'join']);
        Route::post('/leave', [ChatroomController::class, 'leave']);
        Route::apiResource('messages', MessageController::class, ['only' => ['index', 'store']]);
    });
});
