<?php

namespace App\Contracts;

use App\Models\Subscription;

interface SubscriptionRepositoryInterface
{
    public function create(array $data): Subscription;
}
