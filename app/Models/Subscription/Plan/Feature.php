<?php

namespace App\Models\Subscription\Plan;

use App\Models\Concerns\UsesUuid;
use App\Models\Subscription\Plan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Rinvex\Subscriptions\Services\Period;

class Feature extends Model
{
    use UsesUuid;

    /**
     * {@inheritdoc}
     */
    protected $table = 'plan_features';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'plan_id' => 'integer',
        'code' => 'string',
        'value' => 'string',
        'resettable_period' => 'integer',
        'resettable_interval' => 'string',
        'sort_order' => 'integer',
    ];

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function name()
    {
        return trans('plans.'. $this->code);
    }

    /**
     * The model always belongs to a plan.
     *
     * @return BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function isUnlimited(): bool
    {
        return $this->value === 'Y';
    }

    /**
     * Get feature's reset date.
     *
     * @param Carbon $dateFrom
     * @return \Carbon\Carbon
     */
    public function getResetDate(Carbon $dateFrom): Carbon
    {
        $period = new Period($this->resettable_interval, $this->resettable_period, $dateFrom ?? now());

        return $period->getEndDate();
    }
}