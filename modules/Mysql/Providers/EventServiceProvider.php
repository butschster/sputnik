<?php

namespace Module\Mysql\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Module\Mysql\Models\Database;
use Module\Mysql\Observers;

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

        Database::observe([
            Observers\Database\ConsumeSubscriptionFeaturesObserver::class,
            Observers\Database\GenerateDatabasePassword::class,
            Observers\Database\FireEventsObserver::class,
            Observers\Database\SyncDatabaseObserver::class,
        ]);
    }
}
