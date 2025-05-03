<?php

use Illuminate\Support\Facades\Route;
use Modules\Appointment\Http\Controllers\DoctorScheduleController;
use Modules\Appointment\app\Http\Controllers\GetDoctorSlotsController;
use Modules\Appointment\app\Http\Controllers\ReserveSlotsController;
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::prefix('appointments')->group(function () {
        Route::prefix('schedule')->group(function () {
            Route::post('create', [DoctorScheduleController::class, 'create'])->name('doctor.schedule.create');
        });
        Route::prefix('doctors')->group(function () {
            Route::get('{doctor}/slots', GetDoctorSlotsController::class)->name('doctor.slots.list');
        });
        Route::prefix('slots')->group(function () {
            Route::post('{slot}', ReserveSlotsController::class)->name('doctor.slot.reserve');
        });
    });
});

Route::middleware(['auth:client'])->prefix('v1')->group(function () {
    Route::prefix('appointments')->group(function () {
        Route::prefix('doctors')->group(function () {
            Route::get('{doctor}/slots', GetDoctorSlotsController::class)->name('doctor.slots.list');
        });
        Route::prefix('slots')->group(function () {
            Route::post('{slot}', ReserveSlotsController::class)->name('doctor.slot.reserve');
        });
    });
});
