<?php

namespace Modules\Appointment\app\Enums;

enum ReservationStatus : string
{
    case PAID = 'paid';
    case UNDER_PAID = 'under-paid';

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
