<?php

namespace App\Contracts;

use App\Models\Subscription;

interface SubscriptionServiceInterface
{
    public function createSubscription(array $data): Subscription;
}
