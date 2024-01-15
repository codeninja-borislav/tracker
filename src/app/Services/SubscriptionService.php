<?php

namespace App\Services;

use App\Contracts\NotificationRepositoryInterface;
use App\Contracts\SubscriptionRepositoryInterface;
use App\Contracts\SubscriptionServiceInterface;
use Illuminate\Support\Facades\DB;

class SubscriptionService implements SubscriptionServiceInterface
{
    public function __construct(
        protected SubscriptionRepositoryInterface $subscriptionRepo,
        protected NotificationRepositoryInterface $notificationRepo
    ){}

    public function createSubscription(array $data)
    {
        return DB::transaction(function () use ($data) {
            $subscription = $this->subscriptionRepo->create([
                'email' => $data['email'],
                'currency_pair' => $data['currency_pair']
            ]);

            if (!$subscription) {
                return false;
            }

            $this->createNotificationsForSubscription($subscription, $data['notification_conditions'] ?? []);

            return $subscription;
        });
    }

    private function createNotificationsForSubscription($subscription, array $conditions): void
    {
        foreach ($conditions as $condition) {
            $this->notificationRepo->create([
                'subscription_id' => $subscription->id,
                'notification_type' => $condition['type'],
                'threshold_value' => $condition['value'] ?? null,
                'time_interval' => $condition['time_interval'] ?? null,
            ]);
        }
    }
}
