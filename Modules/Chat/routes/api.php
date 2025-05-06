<?php

use Illuminate\Support\Facades\Route;
use Modules\Chat\Http\Controllers\ChatController;



Route::middleware([\Modules\Chat\Http\Middleware\AuthenticateDoctorOrClient::class])->prefix('v1')->group(function () {
    Route::prefix('chat')->group(function () {
        Route::post('send/{conversation_id?}', [ChatController::class, 'sendMessage'])->name('chat.message.send');
    });
});
