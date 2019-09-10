<?php

namespace App\Services\Stripe\Events;

use App\Services\Stripe\Payload;
use Illuminate\Http\Response;

class CustomerUpdated extends Event
{
    /**
     * Handle customer updated.
     *
     * @param Payload $payload
     * @return Response
     */
    public function handle(Payload $payload): Response
    {
        if ($user = $this->getUserByStripeId($payload->getObjectId())) {
            $user->updateDefaultPaymentMethodFromStripe();
        }

        return $this->successMethod();
    }
}