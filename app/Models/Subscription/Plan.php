<?php

namespace App\Models\Subscription;

use App\Models\Concerns\UsesUuid;
use App\Models\Subscription\Plan\Feature;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use UsesUuid, Cachable;

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'float',
        'currency' => 'string',
        'trial_period' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Find plan by name
     *
     * @param string $name
     * @return Plan
     */
    public static function findByName(string $name): Plan
    {
        return static::where('name', $name)->firstOrFail();
    }

    /**
     * The plan may have many features.
     *
     * @return HasMany
     */
    public function features(): HasMany
    {
        return $this->hasMany(Feature::class);
    }

    /**
     * Filter plans only by active status
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOnlyActive(Builder $builder)
    {
        return $builder->where('is_active', true);
    }

    /**
     * Filter plans only with payment
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeWithoutFree(Builder $builder)
    {
        return $builder->where('price', '>', 0);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeWithMonitoring(Builder $builder)
    {
        return $builder->whereHas('features', function ($q) {
            return $q->where('code', 'server.site.monitoring');
        });
    }

    /**
     * Check if plan is free.
     *
     * @return bool
     */
    public function isFree(): bool
    {
        return (float)$this->price <= 0.00;
    }

    /**
     * Get number of days of trial period
     *
     * @return int
     */
    public function trialPeriod(): int
    {
        if ($this->isFree()) {
            return 0;
        }

        return config('auth.subscription.trial_period') ?? 7;
    }

    /**
     * Check if plan has trial.
     *
     * @return bool
     */
    public function hasTrial(): bool
    {
        return $this->trialPeriod() > 0;
    }

    /**
     * Activate the plan.
     *
     * @return void
     */
    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Deactivate the plan.
     *
     * @return void
     */
    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }
}
