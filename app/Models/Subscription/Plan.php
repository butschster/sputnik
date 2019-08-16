<?php

namespace App\Models\Subscription;

use App\Models\Concerns\UsesUuid;
use App\Models\Subscription\Plan\Feature;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use UsesUuid;

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
        'trial_interval' => 'string',
        'invoice_period' => 'integer',
        'invoice_interval' => 'string',
        'prorate_day' => 'integer',
        'prorate_period' => 'integer',
        'prorate_extend_due' => 'integer',
        'sort_order' => 'integer',
    ];

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
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOnlyActive(Builder $builder)
    {
        return $builder->where('is_active', true);
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
     * Check if plan has trial.
     *
     * @return bool
     */
    public function hasTrial(): bool
    {
        return $this->trial_period && $this->trial_interval;
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