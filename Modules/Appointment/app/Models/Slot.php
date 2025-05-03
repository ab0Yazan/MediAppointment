<?php

namespace Modules\Appointment\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\app\Models\Doctor;

// use Modules\Appointment\Database\Factories\SlotFactory;

/**
 * @method static updateOrCreate(array $array, array $array1)
 * @property true $is_reserved
 */
class Slot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['week_day', 'doctor_schedule_id', 'date', 'start_time', 'end_time'];

    // protected static function newFactory(): SlotFactory
    // {
    //     // return SlotFactory::new();
    // }

    public function doctor(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(
            Doctor::class,
            DoctorSchedule::class,
            'id',
            'id',
            'doctor_schedule_id',
            'doctor_id'
        );
    }

    public function isReserved(): bool
    {
        return $this->is_reserved;
    }

    public function reserve(): void
    {
        $this->is_reserved = true;
        $this->save();
    }

    public static function lockForUpdate(int $slotId)
    {
        return self::where('id', $slotId)->lockForUpdate()->firstOrFail();
    }

}
