<?php

namespace Modules\Appointment\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Appointment\Database\Factories\SlotFactory;

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
}
