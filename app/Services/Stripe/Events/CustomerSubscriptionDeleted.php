<?php

namespace App\Services\Stripe\Events;

use App\Services\Stripe\Payload;
use Illuminate\Http\Response;

class CustomerSubscriptionDeleted extends Event
{
    /**
     * Handle a cancelled customer from a Stripe subscription.
     *
     * @param Payload $payload
     * @return Response
     */
    public function handle(Payload $payload): Response
    {
        if ($user = $this->getUserByStripeId($payload->getCustomerId())) {

            $user->subscriptions->filter(function ($subscription) use ($payload) {

                return $subscription->stripe_id === $payload->getObjectId();

            })->each(function ($subscription) {

                $subscription->markAsCancelled();

            });

        }

        return $this->successMethod();
    }
}