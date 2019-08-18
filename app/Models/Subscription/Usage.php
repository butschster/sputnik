<?php

namespace App\Models\Subscription;

use App\Models\Concerns\UsesUuid;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    use UsesUuid, Cachable;

    /**
     * {@inheritdoc}
     */
    protected $table = 'plan_subscription_usage';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'used' => 'integer',
        'valid_until' => 'datetime',
    ];

    /**
     * Scope subscription usage by feature name.
     * @param Builder $builder
     * @param string $code
     * @return Builder
     */
    public function scopeByFeature(Builder $builder, string $code): Builder
    {
        return $builder->where('code', $code);
    }

    /**
     * Check whether usage has been expired or not.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        if (is_null($this->valid_until)) {
            return false;
        }

        return now()->gte($this->valid_until);
    }
}