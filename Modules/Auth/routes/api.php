<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\app\Http\Controllers\DoctorRegisterController;
use Modules\Auth\app\Http\Controllers\DoctorLoginController;

Route::prefix('v1')->group(function () {
    Route::prefix('doctor')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('register', [DoctorRegisterController::class, 'register'])->name('doctor.auth.register');
            Route::post('login', [DoctorLoginController::class, 'login'])->name('doctor.auth.login');
        });
    });
});
