<?php

use Illuminate\Support\Facades\Route;
use Modules\Appointment\Http\Controllers\DoctorScheduleController;
use Modules\Appointment\app\Http\Controllers\GetDoctorSlotsController;
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::prefix('appointments')->group(function () {
        Route::prefix('schedule')->group(function () {
            Route::post('create', [DoctorScheduleController::class, 'create'])->name('doctor.schedule.create');
        });
        Route::prefix('doctors')->group(function () {
            Route::get('{doctor}/slots', GetDoctorSlotsController::class)->name('doctor.slots.list');
        });
    });
});
