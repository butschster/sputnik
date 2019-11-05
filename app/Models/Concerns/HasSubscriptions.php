<?php

namespace App\Models\Concerns;

use App\Events\Subscription\Canceled;
use App\Events\Subscription\Resumed;
use App\Events\Subscription\Subscribed;
use App\Models\Subscription\Plan;
use App\Models\User\Subscription;

trait HasSubscriptions
{
    /**
     * Subscribe team to selected plan
     *
     * @param Plan $plan
     * @param null $paymentMethod
     * @return \Laravel\Cashier\Subscription
     * @throws \Laravel\Cashier\Exceptions\SubscriptionUpdateFailure
     */
    public function subscribeTo(Plan $plan, $paymentMethod = null): \Laravel\Cashier\Subscription
    {
        $name = 'main';

        if ($this->hasActiveSubscription()) {
            $subscription = $this->getActiveSubscription()->swap($plan->name);
        } else {
            $builder = $this->newSubscription($name, $plan->name);

            if ($plan->hasTrial()) {
                $builder->trialDays($plan->trialPeriod());
            } else {
                $builder->skipTrial();
            }

            $subscription = $builder->create($paymentMethod);
        }

        event(new Subscribed($subscription));

        return $subscription;
    }

    /**
     * @return Subscription|null
     */
    public function getActiveSubscription(): ?Subscription
    {
        return $this->subscription('main');
    }

    /**
     * Cancel current subscription
     */
    public function cancelCurrentSubscription(): void
    {
        event(new Canceled(
            $this->getActiveSubscription()->cancel()
        ));
    }

    /**
     * Resume current subscription
     */
    public function resumeCurrentSubscription(): void
    {
        event(new Resumed(
            $this->getActiveSubscription()->resume()
        ));
    }

    /**
     * Check if team has subscription
     *
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
