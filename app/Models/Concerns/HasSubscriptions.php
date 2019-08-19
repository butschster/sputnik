<?php

namespace App\Models\Concerns;

use App\Models\Subscription\Plan;
use App\Models\User\Subscription;

trait HasSubscriptions
{
    /**
     * @param Plan $plan
     * @param \Stripe\PaymentMethod|string|null $paymentMethod
     *
     * @return \Laravel\Cashier\Subscription
     */
    public function subscribeTo(Plan $plan, $paymentMethod = null): \Laravel\Cashier\Subscription
    {
        $name = 'main';

        if ($plan->isFree()) {
            return $this->subscriptions()->create([
                'name' => $name,
                'stripe_id' => null,
                'stripe_status' => 'complete',
                'stripe_plan' => $plan->name,
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => null,
            ]);
        }

        $builder = $this->newSubscription('main', $plan->name);

        if ($plan->hasTrial()) {
            $builder->trialDays($name);
        } else {
            $builder->skipTrial();
        }

        return $builder->create($paymentMethod);
    }

    /**
     * @return Subscription|null
     */
    public function getActiveSubscription(): ?Subscription
    {
        return $this->subscription('main');
    }

    public function cancelCurrentSubscription(): void
    {
        $this->getActiveSubscription()->cancel();
    }

    public function resumeCurrentSubscription(): void
    {
        $this->getActiveSubscription()->resume();
    }

    /**
     * @return bool
     */
    public function hasActiveSubscription(): bool
    {
        return $this->getActiveSubscription() ? $this->getActiveSubscription()->valid() : false;
    }

    /**
     * @param string $code
     *
     * @return bool
     */
    public function canUseFeature(string $code): bool
    {
        if (!$this->hasActiveSubscription()) {
            return false;
        }

        return $this->getActiveSubscription()->canUseFeature($code);
    }

    /**
     * @param string $code
     *
     * @return int
     */
    public function getRemainingOf(string $code): int
    {
        if ($this->hasActiveSubscription()) {
            return $this->getActiveSubscription()->getFeatureRemains($code);
        }

        return 0;
    }

    /**
     * @param string $feature
     * @param int $times
     */
    public function useFeature(string $feature, int $times = 1): void
    {
        if ($this->hasActiveSubscription()) {
            $this->getActiveSubscription()->recordFeatureUsage($feature, $times);
        }
    }

    /**
     * @param string $feature
     * @param int $times
     */
    public function returnFeature(string $feature, int $times = 1): void
    {
        if ($this->hasActiveSubscription()) {
            $this->getActiveSubscription()->reduceFeatureUsage($feature, $times);
        }
    }
}
