<?php

namespace App\Jobs;

use App\Mail\PriceNotificationMail;
use App\Models\Subscription;
use App\Models\Notification;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected Subscription $subscription,
        protected Notification $notification,
        protected mixed $currentPrice
    ){}

    public function handle(): void
    {
        try {
            Mail::to($this->subscription->email)->send(new PriceNotificationMail($this->subscription, $this->notification, $this->currentPrice));

            $this->notification->triggered = true;
            $this->notification->triggered_at = now();
            $this->notification->save();
        } catch (Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
        }
    }
}
