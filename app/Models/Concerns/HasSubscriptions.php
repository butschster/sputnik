<?php

namespace App\Models\Concerns;

use App\Models\User\Subscription;
use App\Models\Subscription\Plan;
use App\Models\Subscription\Period;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasSubscriptions
{
    /**
     * The user may have subscription.
     *
     * @return HasOne
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * Subscribe user to a new plan.
     *
     * @param Plan $plan
     * @param bool $isPaid
     *
     * @return Subscription
     */
    public function subscribeTo(Plan $plan, bool $isPaid = false): Subscription
    {
        if ($this->subscription) {

            $this->subscription->changePlan($plan);

            return $this->subscription;
        }

        $trial = new Period($plan->trial_interval, $plan->trial_period, now());
        $data = [
            'trial_ends_at' => $trial->getEndDate(),
            'starts_at' => $trial->getStartDate(),
            'ends_at' => $trial->getEndDate(),
        ];

        if ($isPaid) {
            $period = new Period($plan->invoice_interval, $plan->invoice_period, $trial->getEndDate());
            $data = array_merge($data, [
                'starts_at' => $period->getStartDate(),
                'ends_at' => $period->getEndDate(),
            ]);
        }

        $subscription = new Subscription($data);
        $subscription->plan()->associate($plan);
        $subscription->team()->associate($this);

        $subscription->save();

        return $subscription;
    }

    public function cancelCurrentSubscription(): void
    {
        $this->subscription->cancel();
    }

    /**
     * @return bool
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscription ? $this->subscription->isActive() : false;
    }

    /**
     * @param string $code
     * @return bool
     */
    public function canUseFeature(string $code): bool
    {
        if (!$this->hasActiveSubscription()) {
            return false;
        }

        return $this->subscription->canUseFeature($code);
    }

    /**
     * @param string $code
     * @return int
     */
    public function getRemainingOf(string $code): int
    {
        if ($this->hasActiveSubscription()) {
            return $this->subscription->getFeatureRemains($code);
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
            $this->subscription->recordFeatureUsage($feature, $times);
        }
    }

    /**
     * @param string $feature
     * @param int $times
     */
    public function returnFeature(string $feature, int $times = 1): void
    {
        if ($this->hasActiveSubscription()) {
            $this->subscription->reduceFeatureUsage($feature, $times);
        }
    }
}
