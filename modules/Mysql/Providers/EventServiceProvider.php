<?php

namespace Module\Mysql\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Module\Mysql\Events\Database\Created;
use Module\Mysql\Events\Database\Deleted;
use Module\Mysql\Models\Database;
use Module\Mysql\Observers;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * @var array
     */
    protected $listen = [
        Created::class => [

        ],
        Deleted::class => [

        ],
    ];

    /**
     * Register any events for your application.
     * @return void
     */
    public function boot()
    {
        parent::boot();

//        Database::observe([
//            Observers\Database\SyncDatabaseObserver::class,
//        ]);
    }
}
