<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\app\Http\Controllers\ClientLoginController;
use Modules\Auth\app\Http\Controllers\DoctorRegisterController;
use Modules\Auth\app\Http\Controllers\DoctorLoginController;
use Modules\Auth\Http\Controllers\RegisterClientController;

Route::prefix('v1')->group(function () {
    Route::prefix('doctor')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('register', [DoctorRegisterController::class, 'register'])->name('doctor.auth.register');
            Route::post('login', [DoctorLoginController::class, 'login'])->name('doctor.auth.login');
        });
    });

    Route::prefix('client')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('register', [RegisterClientController::class, 'register'])->name('client.auth.register');
            Route::post('login', [ClientLoginController::class, 'login'])->name('client.auth.login');
        });
    });
});
