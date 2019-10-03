<?php

namespace Module\Scheduler\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Gate;
use Module\Scheduler\Models\CronJob;
use Module\Scheduler\Policies\CronJobPolicy;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Module service providers
     *
     * @var array
     */
    protected $providers = [
        EventServiceProvider::class,
    ];

    public function boot()
    {
        parent::boot();

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }

        Gate::policy(CronJob::class, CronJobPolicy::class);
    }
}