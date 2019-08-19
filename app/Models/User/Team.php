<?php

namespace App\Models\User;

use App\Models\Concerns\HasSubscriptions;
use App\Models\Concerns\UsesUuid;
use Laratrust\Models\LaratrustTeam;
use Laravel\Cashier\Billable;

class Team extends LaratrustTeam
{
    use UsesUuid,
        HasSubscriptions,
        Billable;

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * Get all of the subscriptions for the Stripe model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'team_id')->orderBy('created_at', 'desc');
    }
}
