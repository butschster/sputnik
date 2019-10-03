<?php

namespace Module\OpenVPN\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Module\OpenVPN\Models\Client;
use Module\OpenVPN\Observers;

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

        Client::observe([
            Observers\Client\FireEventsObserver::class,
            Observers\Client\SyncUserObserver::class,
        ]);
    }
}
