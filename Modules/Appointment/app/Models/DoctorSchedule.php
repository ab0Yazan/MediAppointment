<?php

namespace Modules\Appointment\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Appointment\app\Casts\TimeCast;
use Modules\Appointment\app\Enums\WeekDay;
use Modules\Auth\app\Models\Doctor;

// use Modules\Appointment\Database\Factories\DoctorScheduleFactory;

/**
 * @property string $start_time
 * @property string $end_time
 * @property WeekDay $week_day
 * @property int $id
 * @property mixed $slots
 * @property mixed $doctor_id
 */
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
        "start_time" => TimeCast::class,
        "end_time" => TimeCast::class,
    ];

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
