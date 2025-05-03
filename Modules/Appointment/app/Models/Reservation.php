<?php

namespace Modules\Appointment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Appointment\app\Enums\ReservationStatus;

// use Modules\Appointment\Database\Factories\ReservationFactory;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "client_id",
        "slot_id",
        "status"
    ];

    protected $casts = [
       "status" => ReservationStatus::class
    ];

    // protected static function newFactory(): ReservationFactory
    // {
    //     // return ReservationFactory::new();
    // }
}
