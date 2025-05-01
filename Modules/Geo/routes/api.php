<?php

use Illuminate\Support\Facades\Route;
use Modules\Geo\Http\Controllers\GeoController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('geo', GeoController::class)->names('geo');
});
