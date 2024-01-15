<?php

namespace App\Models;

use App\Enums\NotificationType;
use App\Enums\TimeInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Bool_;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'subscription_notifications';

    protected $fillable = [
        'subscription_id',
        'notification_type',
        'threshold_value',
        'time_interval',
        'triggered',
        'triggered_at',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    protected $casts = [
        'notification_type' => NotificationType::class,
        'time_interval' => TimeInterval::class,
        'triggered' => 'boolean'
    ];
}
