<?php

namespace App\Models;

use App\Models\Subscription\Plan;
use App\Models\User\SourceProvider;
use App\Models\User\Subscription;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Passport\HasApiTokens;
use App\Models\Concerns\UsesUuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Rinvex\Subscriptions\Services\Period;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, UsesUuid;

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
     * The user may have subscription.
     *
     * @return HasOne
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * Subscribe user to a new plan.
     *
     * @param Plan $plan
     * @param bool $isPaid
     *
     * @return Subscription
     */
    public function subscribeTo(Plan $plan, bool $isPaid = false): Subscription
    {
        if ($this->subscription) {

            $this->subscription->changePlan($plan);

            return $this->subscription;
        }

        $trial = new Period($plan->trial_interval, $plan->trial_period, now());
        $data = [
            'trial_ends_at' => $trial->getEndDate(),
            'starts_at' => $trial->getStartDate(),
            'ends_at' => $trial->getEndDate(),
        ];

        if ($isPaid) {
            $period = new Period($plan->invoice_interval, $plan->invoice_period, $trial->getEndDate());
            $data = array_merge($data, [
                'starts_at' => $period->getStartDate(),
                'ends_at' => $period->getEndDate(),
            ]);
        }

        $subscription = new Subscription($data);
        $subscription->plan()->associate($plan);
        $subscription->user()->associate($this);

        $subscription->save();

        return $subscription;
    }

    public function cancelCurrentSubscription()
    {
        $this->subscription->cancel();
    }

    /**
     * @return bool
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscription ? $this->subscription->isActive() : false;
    }

    /**
     * @param string $code
     * @return bool
     */
    public function canUseFeature(string $code): bool
    {
        if (!$this->hasActiveSubscription()) {
            return false;
        }

        return $this->subscription->canUseFeature($code);
    }

    public function getRemainingOf(string $code)
    {
        if ($this->hasActiveSubscription()) {
            return $this->subscription->getFeatureRemains($code);
        }
    }

    /**
     * @param string $feature
     * @param int $times
     */
    public function useFeature(string $feature, int $times = 1): void
    {
        if ($this->hasActiveSubscription()) {
            $this->subscription->recordFeatureUsage($feature, $times);
        }
    }

    /**
     * @param string $feature
     * @param int $times
     */
    public function returnFeature(string $feature, int $times = 1): void
    {
        if ($this->hasActiveSubscription()) {
            $this->subscription->reduceFeatureUsage($feature, $times);
        }
    }
}
