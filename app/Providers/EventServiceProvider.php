<?php

namespace App\Providers;

use App\Events\Server;
use App\Events\Server\KeysInstalled;
use App\Listeners\Server\AddPublicKeyToServer;
use App\Listeners\Server\CreateHttpFirewallRules;
use App\Listeners\Server\RemovePublicKeyFromServer;
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
        Server\PublicKey\AttachedToServer::class => [
            AddPublicKeyToServer::class,
        ],
        Server\PublicKey\DetachedFromServer::class => [
            RemovePublicKeyFromServer::class,
        ],
        Server\Configured::class => [
            CreateHttpFirewallRules::class,
        ],
    ];

    /**
     * Register any events for your application.
     * @return void
     */
    public function boot()
    {
        parent::boot();

        \App\Models\Server::observe([
            \App\Observers\Server\GenerateSshKeyPairsObserver::class,
            \App\Observers\Server\GenerateDatabasePassword::class,
        ]);

        \App\Models\Server\PublicKey::observe([
            \App\Observers\Server\PublicKey\FireEventsObserver::class,
        ]);

        \App\Models\Server\Site::observe([
            \App\Observers\Server\Site\GenerateRandomTokenObserver::class,
            \App\Observers\Server\Site\FireEventsObserver::class,
            \App\Observers\Server\Site\SyncSiteObserver::class,
        ]);

        \App\Models\Server\CronJob::observe([
            \App\Observers\Server\Cron\SyncCronJobsObserver::class,
            \App\Observers\Server\Cron\FireEventsObserver::class,
        ]);


        \App\Models\Server\Firewall\Rule::observe([
            \App\Observers\Server\Firewall\SyncFirewallRuleObserver::class,
        ]);
    }
}
