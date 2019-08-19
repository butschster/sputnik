<?php

namespace App\Models\User;

use App\Models\Concerns\UsesUuid;
use App\Models\Subscription\Plan;
use App\Models\Subscription\Usage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Cashier\Subscription as SubscriptionBase;

class Subscription extends SubscriptionBase
{
    use UsesUuid;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'stripe_plan', 'name');
    }

    /**
     * The subscription may have many usage.
     *
     * @return HasMany
     */
    public function usage(): hasMany
    {
        return $this->hasMany(Usage::class, 'team_id', 'team_id');
    }

    /**
     * Record feature usage.
     *
     * @param string $code
     * @param int $uses
     *
     * @return Usage
     */
    public function recordFeatureUsage(string $code, int $uses = 1): Usage
    {
        $feature = $this->plan->features()->where('code', $code)->first();

        $usage = $this->usage()->firstOrNew([
            'code' => $code,
        ]);

        if ($feature->resettable_period) {
            // Set expiration date when the usage record is new or doesn't have one.
            if (is_null($usage->valid_until)) {
                // Set date from subscription creation date so the reset
                // period match the period specified by the subscription's plan.
                $usage->valid_until = $feature->getResetDate($this->created_at);
            } else if ($usage->isExpired()) {
                // If the usage record has been expired, let's assign
                // a new expiration date and reset the uses to zero.
                $usage->valid_until = $feature->getResetDate($usage->valid_until);
                $usage->used = 0;
            }
        }

        $usage->used += $uses;

        $usage->save();

        return $usage;
    }

    /**
     * Reduce usage.
     *
     * @param string $code
     * @param int $uses
     *
     * @return Usage|null
     */
    public function reduceFeatureUsage(string $code, int $uses = 1): ?Usage
    {
        $usage = $this->usage()->firstOrNew([
            'code' => $code,
        ]);

        if (is_null($usage)) {
            return null;
        }

        $usage->used = max($usage->used - $uses, 0);

        $usage->save();

        return $usage;
    }

    /**
     * Determine if the feature can be used.
     *
     * @param string $code
     *
     * @return bool
     */
    public function canUseFeature(string $code): bool
    {
        $featureValue = $this->getFeatureValue($code);

        if ($featureValue === 'true') {
            return true;
        }

        $usage = $this->usage()->byFeature($code)->first();
        if (!$usage) {
            return true;
        }

        // If the feature value is zero, let's return false since
        // there's no uses available. (useful to disable countable features)
        if ($usage->isExpired() || is_null($featureValue) || $featureValue === '0' || $featureValue === 'false') {
            return false;
        }

        // Check for available uses
        return $this->getFeatureRemains($code) > 0;
    }

    /**
     * Get the available uses.
     *
     * @param string $code
     *
     * @return int
     */
    public function getFeatureRemains(string $code): int
    {
        $value = $this->getFeatureValue($code);

        if ($value === 'Y') {
            return 1;
        }

        return $this->getFeatureValue($code) - $this->getFeatureUsage($code);
    }

    /**
     * Get how many times the feature has been used.
     *
     * @param string $code
     *
     * @return int
     */
    public function getFeatureUsage(string $code): int
    {
        $usage = $this->usage()->byFeature($code)->first();

        if (!$usage) {
            return 0;
        }

        return !$usage->isExpired() ? $usage->used : 0;
    }

    /**
     * Get feature value.
     *
     * @param string $code
     *
     * @return int|null
     */
    public function getFeatureValue(string $code)
    {
        $feature = $this->plan->features()->where('code', $code)->first();

        return $feature->value ?? null;
    }

}
