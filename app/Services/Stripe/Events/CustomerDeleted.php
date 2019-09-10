<?php

namespace App\Services\Stripe\Events;

use App\Services\Stripe\Payload;
use Illuminate\Http\Response;
use Laravel\Cashier\Subscription;

class CustomerDeleted extends Event
{

    /**
     * Handle deleted customer.
     *
     * @param Payload $payload
     *
     * @return Response
     */
    public function handle(Payload $payload): Response
    {
        if ($user = $this->getUserByStripeId($payload->getObjectId())) {

            $user->subscriptions->each(function (Subscription $subscription) {
                $subscription->skipTrial()->markAsCancelled();
            });

            $user->forceFill([
                'stripe_id' => null,
                'trial_ends_at' => null,
                'card_brand' => null,
                'card_last_four' => null,
            ])->save();

        }

        return $this->successMethod();
    }
}