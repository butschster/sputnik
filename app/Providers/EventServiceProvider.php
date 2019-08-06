<?php

namespace App\Providers;

use App\Events\Server;
use App\Events\Server\KeysInstalled;
use App\Listeners\Server\AddPublicKeyToServer;
use App\Listeners\Server\CreateHttpFirewallRules;
use App\Listeners\Server\RemovePublicKeyFromServer;
use App\Observers\Server\Firewall\DisableRuleAfterDeleting;
use App\Observers\Server\GenerateDatabasePassword;
use App\Observers\Server\GenerateSshKeyPairsObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        KeysInstalled::class => [

        ],
        Server\Key\AttachedToServer::class => [
            AddPublicKeyToServer::class,
        ],
        Server\Key\DetachedFromServer::class => [
            RemovePublicKeyFromServer::class,
        ],
        Server\Configured::class => [
            CreateHttpFirewallRules::class
        ]
    ];

    /**
     * Register any events for your application.
     * @return void
     */
    public function boot()
    {
        parent::boot();

        \App\Models\Server::observe([
            GenerateSshKeyPairsObserver::class,
            GenerateDatabasePassword::class,
        ]);

        \App\Models\Server\Firewall::observe([
            DisableRuleAfterDeleting::class
        ]);
    }
}
