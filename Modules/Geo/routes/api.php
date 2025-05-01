<?php

use Illuminate\Support\Facades\Route;
use Modules\Geo\Http\Controllers\GeoController;

Route::middleware(['auth:client'])->prefix('v1')->group(function () {
    Route::prefix('geo')->group(function () {
        Route::post('search', \Modules\Geo\app\Http\Controllers\SearchNearestDoctorController::class)->name('geo.search');
    });
});

Route::middleware(['auth:doctor'])->prefix('v1')->group(function () {
    Route::prefix('geo')->group(function () {
        Route::post('create', )->name('geo.search');
    });
});
