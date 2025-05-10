<?php

use Illuminate\Support\Facades\Route;
use Modules\Storage\Http\Controllers\StorageController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('storages', StorageController::class)->names('storage');
});
