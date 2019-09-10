<?php

namespace App\Services\Stripe\Events;

use App\Services\Stripe\Payload;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Subscription;

class CustomerSubscriptionUpdated extends Event
{
    /**
     * Handle customer subscription updated.
     *
     * @param  Payload  $payload
     * @return Response
     */
    public function handle(Payload $payload): Response
    {
        if ($user = $this->getUserByStripeId($payload->getCustomerId())) {
            $data = $payload->getObject();

            $user->subscriptions->filter(function (Subscription $subscription) use ($data) {
                return $subscription->stripe_id === $data['id'];
            })->each(function (Subscription $subscription) use ($data) {
                if (isset($data['status']) && $data['status'] === 'incomplete_expired') {
                    $subscription->delete();

                    return;
                }

                // Quantity...
                if (isset($data['quantity'])) {
                    $subscription->quantity = $data['quantity'];
                }

                // Plan...
                if (isset($data['plan']['id'])) {
                    $subscription->stripe_plan = $data['plan']['id'];
                }

                // Trial ending date...
                if (isset($data['trial_end'])) {
                    $trial_ends = Carbon::createFromTimestamp($data['trial_end']);

                    if (! $subscription->trial_ends_at || $subscription->trial_ends_at->ne($trial_ends)) {
                        $subscription->trial_ends_at = $trial_ends;
                    }
                }

                // Cancellation date...
                if (isset($data['cancel_at_period_end'])) {
                    if ($data['cancel_at_period_end']) {
                        $subscription->ends_at = $subscription->onTrial()
                            ? $subscription->trial_ends_at
                            : Carbon::createFromTimestamp($data['current_period_end']);
                    } else {
                        $subscription->ends_at = null;
                    }
                }

                // Status...
                if (isset($data['status'])) {
                    $subscription->stripe_status = $data['status'];
                }

                $subscription->save();
            });
        }

        return $this->successMethod();
    }
}