<?php

namespace App\Services;

use App\Contracts\BitcoinPriceInterface;
use App\Contracts\BitcoinPriceRepositoryInterface;
use App\Contracts\NotificationServiceInterface;
use App\Jobs\SendNotificationJob;
use App\Models\Subscription;

class NotificationService implements NotificationServiceInterface
{

    public function __construct(
        protected BitcoinPriceRepositoryInterface $bitcoinPriceRepository,
        protected BitcoinPriceInterface $bitcoinPrice
    ){}

    public function checkAndNotifyUsers(): void
    {
        $subscriptionGroups = Subscription::with('notifications')
            ->whereHas('notifications', function ($query) {
                $query->where('triggered', false);
            })
            ->get()
            ->groupBy('currency_pair.value');

        foreach ($subscriptionGroups as $currencyPair => $subscriptions) {
            $currentPrice = $this->bitcoinPrice->getBitcoinPrice($currencyPair);

            if (!$currentPrice) {
                continue;
            }

            foreach ($subscriptions as $subscription) {
                $this->processSubscriptionNotifications($subscription, $currentPrice);
            }
        }
    }

    private function processSubscriptionNotifications($subscription, $currentPrice): void {
        foreach ($subscription->notifications as $notification) {
            if (!$notification->triggered && $this->isConditionMet($subscription, $notification, $currentPrice)) {
                SendNotificationJob::dispatch($subscription, $notification, $currentPrice);
            }
        }
    }

    private function isConditionMet($subscription, $notification, $currentPrice): bool
    {
        if (!$currentPrice) {
            return false;
        }

        switch ($notification->notification_type->value) {
            case 'price_limit':
                return $currentPrice->lastPrice >= $notification->threshold_value;
            case 'percentage_change':
                return $this->checkPercentageChange($currentPrice->lastPrice, $notification->threshold_value, $notification->time_interval, $subscription);
            default:
                return false;
        }
    }

    private function checkPercentageChange($currentPrice, $thresholdPercentage, $timeInterval, $subscription): bool
    {
        $historicalPrices = $this->bitcoinPriceRepository->getDynamicHistoricalPriceData($subscription->currency_pair->value, $timeInterval->value);

        if (!count($historicalPrices)) {
            return false;
        }

        $latestPrice = $currentPrice;
        $pastPrice = $historicalPrices[count($historicalPrices) - 1]->price;

        echo $pastPrice;

        $percentageChange = (($latestPrice - $pastPrice) / $pastPrice) * 100;

        return abs($percentageChange) >= $thresholdPercentage;
    }
}
