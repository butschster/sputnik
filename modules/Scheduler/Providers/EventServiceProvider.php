<?php

namespace Module\Scheduler\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Module\Scheduler\Observers;
use Module\Scheduler\Models\CronJob;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * @var array
     */
    protected $listen = [

    ];

    /**
     * Register any events for your application.
     * @return void
     */
    public function boot()
    {
        parent::boot();

        CronJob::observe([
            Observers\CronJob\ConsumeSubscriptionFeaturesObserver::class,
            Observers\CronJob\FireEventsObserver::class,
            Observers\CronJob\SyncCronJobsObserver::class,
        ]);
    }
}
