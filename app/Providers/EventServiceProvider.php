<?php

namespace App\Providers;

use App\Events\WebHooks;
use App\Events\Task;
use App\Events\Server;
use App\Events\Server\KeysInstalled;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * @var array
     */
    protected $listen = [
        Registered::class => [
            \Illuminate\Auth\Listeners\SendEmailVerificationNotification::class,
        ],
        KeysInstalled::class => [

        ],
        Server\Configured::class => [
            \App\Listeners\Server\CreateHttpFirewallRules::class,
            \App\Listeners\Server\ScheduleSystemJobs::class
        ],
        Server\Created::class => [
            \App\Listeners\Server\RegisterSystemUsers::class
        ],
        Server\Site\Created::class => [
            \App\Listeners\Server\Site\LookupDomainInformation::class
        ],
        Server\Site\Deployment\Finished::class => [
            \App\Listeners\Server\RestartSupervisor::class
        ],
        Task\Running::class => [
            \App\Listeners\Server\Site\UpdateDeploymentStatus::class
        ],
        Task\Finished::class => [
            \App\Listeners\Server\Site\UpdateDeploymentStatus::class
        ],
        WebHooks\Ping::class => [

        ],
        WebHooks\Push::class => [
            \App\Listeners\Server\Site\WebHooks\DeploySite::class
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
            \App\Observers\Server\GenerateSshKeyPairsObserver::class,
            \App\Observers\Server\ConsumeSubscriptionFeaturesObserver::class,
            \App\Observers\Server\GenerateDatabasePassword::class,
        ]);

        \App\Models\Server\User::observe([
            \App\Observers\Server\User\GenerateSshKeyPairsObserver::class,
            \App\Observers\Server\User\GenerateUserPassword::class,
            \App\Observers\Server\User\SyncUserObserver::class,
        ]);

        \App\Models\Server\User\PublicKey::observe([
            \App\Observers\Server\User\PublicKey\FireEventsObserver::class,
        ]);

        \App\Models\Server\Daemon::observe([
            \App\Observers\Server\Supervisor\ConsumeSubscriptionFeaturesObserver::class,
            \App\Observers\Server\Supervisor\FireEventsObserver::class,
            \App\Observers\Server\Supervisor\SyncDaemonObserver::class,
        ]);

        \App\Models\Server\Site::observe([
            \App\Observers\Server\Site\GenerateRandomTokenObserver::class,
            \App\Observers\Server\Site\ConsumeSubscriptionFeaturesObserver::class,
            \App\Observers\Server\Site\FireEventsObserver::class,
            \App\Observers\Server\Site\SyncSiteObserver::class,
        ]);

        \App\Models\Server\Site\Deployment::observe([
            \App\Observers\Server\Site\Deployment\ConsumeSubscriptionFeaturesObserver::class
        ]);

        \App\Models\Server\CronJob::observe([
            \App\Observers\Server\Cron\ConsumeSubscriptionFeaturesObserver::class,
            \App\Observers\Server\Cron\FireEventsObserver::class,
            \App\Observers\Server\Cron\SyncCronJobsObserver::class,
        ]);

        \App\Models\Server\Database::observe([
            \App\Observers\Server\Database\ConsumeSubscriptionFeaturesObserver::class,
            \App\Observers\Server\Database\FireEventsObserver::class,
            \App\Observers\Server\Database\SyncDatabaseObserver::class,
        ]);

        \App\Models\Server\Firewall\Rule::observe([
            \App\Observers\Server\Firewall\SyncFirewallRuleObserver::class,
        ]);
    }
}
