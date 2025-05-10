<?php

use Illuminate\Support\Facades\Route;
use Modules\Storage\Http\Controllers\StorageController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('storages', StorageController::class)->names('storage');
});
