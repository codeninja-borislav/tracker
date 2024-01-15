<?php

namespace App\Models;

use App\Enums\CurrencyPair;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitcoinPrice extends Model
{
    use HasFactory;

    protected $fillable = ['currency_pair', 'price', 'timestamp'];

    protected $casts = [
        'currency_pair' => CurrencyPair::class,
    ];
}
