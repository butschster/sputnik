<?php

namespace App\Models\Subscription\Plan;

use App\Models\Concerns\UsesUuid;
use App\Models\Subscription\Plan;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feature extends Model
{
    use UsesUuid, Cachable;

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
        'sort_order' => 'integer',
    ];

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function name(): string
    {
        return trans('plans.' . $this->code);
    }

    /**
     * The model always belongs to a plan.
     * @return BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Check if feature is unlimited
     * @return bool
     */
    public function isUnlimited(): bool
    {
        return $this->value === 'Y';
    }
}
