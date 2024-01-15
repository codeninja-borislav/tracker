<?php

namespace App\Enums;

enum CurrencyPair: string
{
    case BTCEUR = 'BTCEUR';
    case BTCUSD = 'BTCUSD';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
