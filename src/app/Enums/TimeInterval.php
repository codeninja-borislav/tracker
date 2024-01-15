<?php

namespace App\Enums;

enum TimeInterval: string
{
    case OneHour = '1_hour';
    case SixHours = '6_hours';
    case TwentyFourHours = '24_hours';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
