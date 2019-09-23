<?php

namespace App\Models\User;

use App\Models\Concerns\HasSubscriptions;
use App\Models\Concerns\UsesUuid;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * @return HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'team_id')->orderBy('created_at', 'desc');
    }

    /**
     * Get team owner
     * 
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Check if user is owner
     *
     * @param User $user
     *
     * @return bool
     */
    public function isOwner(User $user): bool
    {
        return $this->owner_id === $user->id;
    }

    /**
     * Get owner email address
     *
     * @return string
     */
    public function getEmailAttribute(): string
    {
        return $this->owner->email;
    }
}
