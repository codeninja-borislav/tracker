<?php

namespace App\Models;

use App\Enums\CurrencyPair;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'email',
        'currency_pair',
    ];

    protected $casts = [
        'currency_pair' => CurrencyPair::class,
    ];

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
