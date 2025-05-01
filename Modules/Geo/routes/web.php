<?php

use Illuminate\Support\Facades\Route;
use Modules\Geo\Http\Controllers\GeoController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('geo', GeoController::class)->names('geo');
});
