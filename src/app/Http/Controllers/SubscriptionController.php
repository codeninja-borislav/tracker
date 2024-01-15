<?php

namespace App\Http\Controllers;

use App\Contracts\SubscriptionServiceInterface;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    public function __construct(protected SubscriptionServiceInterface $subscriptionService)
    {
    }

    /**
     * Create a new subscription.
     *
     * @param SubscriptionRequest $request The request object containing subscription details.
     * @return JsonResponse Returns a JSON response indicating the result of the creation operation.
     */
    public function create(SubscriptionRequest $request): JsonResponse
    {
        $subscription = $this->subscriptionService->createSubscription($request->validated());

        if ($subscription) {
            return response()->json(['message' => 'Subscription created successfully.'], 201);
        } else {
            return response()->json(['message' => 'Failed to create subscription.'], 500);
        }
    }
}
