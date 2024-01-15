<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Contracts\SubscriptionRepositoryInterface;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function create(array $data): Subscription
    {
        return Subscription::create($data);
    }
}
