<?php

namespace Modules\Appointment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Appointment\app\Enums\WeekDay;

// use Modules\Appointment\Database\Factories\DoctorScheduleFactory;

final class DoctorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        "doctor_id",
        "week_day",
        "start_time",
        "end_time",
    ];

    protected $casts = [
        "week_day" => WeekDay::class,
    ];
}
