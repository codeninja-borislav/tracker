<?php

namespace App\Providers;

use App\Contracts\BitcoinPriceRepositoryInterface;
use App\Contracts\NotificationRepositoryInterface;
use App\Contracts\NotificationServiceInterface;
use App\Contracts\SubscriptionRepositoryInterface;
use App\Contracts\SubscriptionServiceInterface;
use App\Repositories\BitcoinPriceRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\SubscriptionRepository;
use App\Services\NotificationService;
use App\Services\SubscriptionService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\BitcoinPriceInterface;
use App\Services\BitfinexService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            BitcoinPriceInterface::class,
            BitfinexService::class
        );

        $this->app->bind(
            BitcoinPriceRepositoryInterface::class,
            BitcoinPriceRepository::class
        );

        $this->app->bind(
            SubscriptionRepositoryInterface::class,
            SubscriptionRepository::class
        );

        $this->app->bind(
            SubscriptionServiceInterface::class,
            SubscriptionService::class
        );

        $this->app->bind(
            NotificationRepositoryInterface::class,
            NotificationRepository::class
        );

        $this->app->bind(
            NotificationServiceInterface::class,
            NotificationService::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
