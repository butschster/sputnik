<?php

namespace App\Services\Stripe\Events;

use App\Services\Stripe\Contracts\Event as EventContract;
use Illuminate\Http\Response;
use Laravel\Cashier\Billable;

abstract class Event implements EventContract
{
    /**
     * Get the billable entity instance by Stripe ID.
     *
     * @param string|null $stripeId
     * @return \Laravel\Cashier\Billable|null
     */
    protected function getUserByStripeId(?string $stripeId): ?Billable
    {
        if ($stripeId === null) {
            return null;
        }

        $model = config('cashier.model');

        return (new $model)->where('stripe_id', $stripeId)->first();
    }

    /**
     * Handle successful calls on the controller.
     *
     * @param array $parameters
     * @return Response
     */
    protected function successMethod(array $parameters = []): Response
    {
        return new Response('Webhook Handled', 200);
    }
}