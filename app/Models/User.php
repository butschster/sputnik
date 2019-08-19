<?php

namespace App\Models;

use App\Models\User\SourceProvider;
use App\Models\User\Team;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passport\HasApiTokens;
use App\Models\Concerns\UsesUuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait,
        HasApiTokens,
        Notifiable,
        UsesUuid;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the servers that belong to the user.
     *
     * @return HasMany
     */
    public function servers(): HasMany
    {
        return $this->hasMany(Server::class);
    }

    /**
     * Get connected source providers
     *
     * @return HasMany
     */
    public function sourceProviders(): HasMany
    {
        return $this->hasMany(SourceProvider::class);
    }

    /**
     * @return bool
     */
    public function hasActiveSubscription(): bool
    {
        return $this->rolesTeams->filter(function(Team $team) {
            return $team->hasActiveSubscription();
        })->count() > 0;
    }

    /**
     * @param string $code
     *
     * @return bool
     */
    public function canUseFeature(string $code): bool
    {
        return $this->rolesTeams->filter(function(Team $team) use($code) {
            return $team->canUseFeature($code);
        })->count() > 0;
    }
}
