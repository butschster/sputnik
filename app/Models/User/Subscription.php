<?php

namespace App\Models\User;

use App\Models\Concerns\UsesUuid;
use App\Models\Subscription\Period;
use App\Models\Subscription\Plan;
use App\Models\Subscription\Usage;
use App\Models\User;
use DB;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use UsesUuid, Cachable;

    /**
     * {@inheritdoc}
     */
    protected $table = 'plan_subscriptions';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'cancels_at' => 'datetime',
        'canceled_at' => 'datetime',
    ];

    /**
     * Get the owning user.
     *
     * @return BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the owning user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The subscription may have many usage.
     *
     * @return HasMany
     */
    public function usage(): hasMany
    {
        return $this->hasMany(Usage::class, 'user_id', 'user_id');
    }

    /**
     * Check if subscription is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return !$this->isEnded() || $this->onTrial();
    }


    /**
     * Check if subscription is inactive.
     *
     * @return bool
     */
    public function isInactive(): bool
    {
        return !$this->isActive();
    }

    /**
     * Check if subscription is canceled.
     *
     * @return bool
     */
    public function isCanceled(): bool
    {
        return $this->canceled_at ? now()->gte($this->canceled_at) : false;
    }

    /**
     * Check if subscription is currently on trial.
     *
     * @return bool
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at ? now()->lt($this->trial_ends_at) : false;
    }

    /**
     * Check if subscription period has ended.
     *
     * @return bool
     */
    public function isEnded(): bool
    {
        return $this->ends_at ? now()->gte($this->ends_at) : false;
    }

    /**
     * Cancel subscription.
     *
     * @param bool $immediately
     *
     * @return void
     */
    public function cancel($immediately = false): void
    {
        $this->canceled_at = now();

        if ($immediately) {
            $this->ends_at = $this->canceled_at;
        }

        $this->save();
    }

    /**
     * Change subscription plan.
     *
     * @param Plan $plan
     */
    public function changePlan(Plan $plan): void
    {
        // If plans does not have the same billing frequency
        // (e.g., invoice_interval and invoice_period) we will update
        // the billing dates starting today, and sice we are basically creating
        // a new billing cycle, the usage data will be cleared.
        if ($this->plan->invoice_interval !== $plan->invoice_interval || $this->plan->invoice_period !== $plan->invoice_period) {
            $this->setNewPeriod($plan->invoice_interval, $plan->invoice_period);
        }

        $this->trial_ends_at = null;

        // Attach new plan to subscription
        $this->plan()->associate($plan);

        $this->save();
    }

    /**
     * Renew subscription period.
     *
     * @throws \LogicException
     */
    public function renew()
    {
        $subscription = $this;

        DB::transaction(function () use ($subscription) {
            // Renew period
            $subscription->setNewPeriod();
            $subscription->canceled_at = null;
            $subscription->save();
        });
    }

    /**
     * Set new subscription period.
     *
     * @param string $invoiceInterval
     * @param int $invoicePeriod
     * @param string $start
     *
     * @return void
     */
    protected function setNewPeriod(string $invoiceInterval = '', int $invoicePeriod = null, $start = null): void
    {
        if (empty($invoiceInterval)) {
            $invoiceInterval = $this->plan->invoice_interval;
        }

        if (empty($invoicePeriod)) {
            $invoicePeriod = $this->plan->invoice_period;
        }

        $period = new Period($invoiceInterval, $invoicePeriod, $start);

        $this->starts_at = $period->getStartDate();
        $this->ends_at = $period->getEndDate();
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
            } elseif ($usage->isExpired()) {
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

    /**
     * Scope subscriptions with ending trial.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param int $dayRange
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindEndingTrial(Builder $builder, int $dayRange = 3): Builder
    {
        $from = now();
        $to = now()->addDays($dayRange);

        return $builder->whereBetween('trial_ends_at', [$from, $to]);
    }

    /**
     * Scope subscriptions with ended trial.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindEndedTrial(Builder $builder): Builder
    {
        return $builder->where('trial_ends_at', '<=', now());
    }

    /**
     * Scope subscriptions with ending periods.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param int $dayRange
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindEndingPeriod(Builder $builder, int $dayRange = 3): Builder
    {
        $from = now();
        $to = now()->addDays($dayRange);

        return $builder->whereBetween('ends_at', [$from, $to]);
    }

    /**
     * Scope subscriptions with ended periods.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindEndedPeriod(Builder $builder): Builder
    {
        return $builder->where('ends_at', '<=', now());
    }
}