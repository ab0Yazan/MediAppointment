<?php

namespace Modules\Appointment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Appointment\app\Enums\WeekDay;

// use Modules\Appointment\Database\Factories\DoctorScheduleFactory;

/**
 * @property string $start_time
 * @property string $end_time
 * @property WeekDay $week_day
 * @property int $id
 * @property mixed $slots
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
    ];

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
