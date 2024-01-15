<?php

namespace App\Enums;

enum NotificationType: string
{
    case PriceLimit = 'price_limit';
    case PercentageChange = 'percentage_change';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
