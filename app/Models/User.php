<?php

namespace App\Models;

use App\Models\User\SourceProvider;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passport\HasApiTokens;
use App\Models\Concerns\UsesUuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Rennokki\Plans\Traits\HasPlans;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, UsesUuid, HasPlans;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
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
     * @param string $feature
     * @return bool
     */
    public function canUseFeature(string $feature): bool
    {
        if (!$this->hasActiveSubscription()) {
            return false;
        }

        $usage = $this->activeSubscription()->getRemainingOf($feature);

        if ($usage === -1) {
            return true;
        }

        return $usage > 0;
    }

    /**
     * @param string $feature
     * @param int $times
     */
    public function useFeature(string $feature, int $times = 1): void
    {
        if ($this->hasActiveSubscription()) {
            $this->activeSubscription()->consumeFeature($feature, $times);
        }
    }

    /**
     * @param string $feature
     * @param int $times
     */
    public function returnFeature(string $feature, int $times = 1): void
    {
        if ($this->hasActiveSubscription()) {
            $this->activeSubscription()->unconsumeFeature($feature, $times);
        }
    }
}
