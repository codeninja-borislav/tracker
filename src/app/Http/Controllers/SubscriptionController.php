<?php

namespace App\Http\Controllers;

use App\Contracts\SubscriptionServiceInterface;
use App\Http\Requests\SubscriptionRequest;

class SubscriptionController extends Controller
{
    public function __construct(protected SubscriptionServiceInterface $subscriptionService)
    {
    }

    public function create(SubscriptionRequest $request)
    {
        $subscription = $this->subscriptionService->createSubscription($request->validated());

        if ($subscription) {
            return response()->json(['message' => 'Subscription created successfully.'], 201);
        } else {
            return response()->json(['message' => 'Failed to create subscription.'], 500);
        }
    }
}
