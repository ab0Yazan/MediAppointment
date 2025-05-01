<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('slots:generate', function () {
    $this->call(\Modules\Appointment\app\Console\GenerateDoctorSlots::class);
})->describe('Generate doctor time slots');
