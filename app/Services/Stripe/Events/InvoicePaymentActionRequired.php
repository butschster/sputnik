<?php

namespace App\Services\Stripe\Events;

use App\Services\Stripe\Payload;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Payment;
use Stripe\PaymentIntent as StripePaymentIntent;

class InvoicePaymentActionRequired extends Event
{

    /**
     * Handle payment action required for invoice.
     *
     * @param Payload $payload
     *
     * @return Response
     */
    public function handle(Payload $payload): Response
    {
        if (is_null($notification = config('cashier.payment_notification'))) {
            return $this->successMethod();
        }

        if ($user = $this->getUserByStripeId($payload->getCustomerId())) {
            if (in_array(Notifiable::class, class_uses_recursive($user))) {
                $payment = new Payment(StripePaymentIntent::retrieve(
                    $payload->getPaymentIntent(),
                    $user->stripeOptions()
                ));

                $user->notify(new $notification($payment));
            }
        }

        return $this->successMethod();
    }
}