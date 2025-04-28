<?php

namespace Modules\Appointment\app\Enums;

enum WeekDay : string
{
    case SAT = 'sat';
    case SUN = 'sun';
    case MON = 'mon';
    case TUE = 'tue';
    case WED = 'wed';
    case THU = 'thu';
    case FRI = 'fri';

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
