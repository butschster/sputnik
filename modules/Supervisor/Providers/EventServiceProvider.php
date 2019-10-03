<?php

namespace Module\Supervisor\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Module\Supervisor\Models\Daemon;
use Module\Supervisor\Observers;

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

        Daemon::observe([
            Observers\Daemon\ConsumeSubscriptionFeaturesObserver::class,
            Observers\Daemon\FireEventsObserver::class,
            Observers\Daemon\SyncDaemonObserver::class,
        ]);
    }
}
