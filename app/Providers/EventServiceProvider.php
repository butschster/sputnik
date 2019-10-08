<?php

namespace App\Providers;

use App\Events\Server;
use App\Events\Server\KeysInstalled;
use App\Events\Task;
use App\Events\WebHooks;
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
            \App\Listeners\Server\CreateSSHFirewallRules::class,
            \App\Listeners\Server\InstallModulesWhenServerWasConfigured::class,
        ],
        Server\Created::class => [
            \App\Listeners\Server\RegisterSystemUsers::class,
        ],
        Server\Module\Installed::class => [
            \App\Listeners\Server\ClearModuleMetaInformation::class,
            \App\Listeners\Server\Module\MarkModuleAsInstalled::class,
        ],
        Server\Alert\Created::class => [
            \App\Listeners\Server\Alert\UpdateLastAlertTimestampForCollaborators::class,
            \App\Listeners\Server\Alert\TrimAlertsForProject::class,
        ],
        Server\Site\Created::class => [
            \App\Listeners\Server\Site\LookupDomainInformation::class,
        ],
        Server\Site\Deployment\Finished::class => [
            \App\Listeners\Server\RestartSupervisor::class,
        ],
        Task\Running::class => [
            \App\Listeners\Server\Site\UpdateDeploymentStatus::class,
        ],
        Task\Finished::class => [
            \App\Listeners\Server\Site\UpdateDeploymentStatus::class,
        ],
        Task\CallbacksHandled::class => [
            \App\Listeners\Server\Task\RemoveCallbacksFromTask::class,
        ],
        WebHooks\Ping::class => [

        ],
        WebHooks\Push::class => [
            \App\Listeners\Server\Site\WebHooks\DeploySite::class,
        ],
        Server\Module\ActionRan::class => [
            \App\Listeners\Server\Module\CreateModuleWhenInstallActionWasRun::class,
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
            \App\Observers\Server\ConsumeSubscriptionFeaturesObserver::class,
        ]);

        \App\Models\Server\Event::observe([
            \App\Observers\Server\Event\FireEventsObserver::class,
        ]);

        \App\Models\Server\Site::observe([
            \App\Observers\Server\Site\GenerateRandomTokenObserver::class,
            \App\Observers\Server\Site\ConsumeSubscriptionFeaturesObserver::class,
            \App\Observers\Server\Site\FireEventsObserver::class,
            \App\Observers\Server\Site\SyncSiteObserver::class,
        ]);

        \App\Models\Server\User::observe([
            \App\Observers\Server\User\GenerateSshKeyPairsObserver::class,
            \App\Observers\Server\User\GenerateUserPassword::class,
            \App\Observers\Server\User\SyncUserObserver::class,
        ]);

        //        \App\Models\Server\User\PublicKey::observe([
        //            \App\Observers\Server\User\PublicKey\FireEventsObserver::class,
        //        ]);
        //
        //        \App\Models\Server\Site\Deployment::observe([
        //            \App\Observers\Server\Site\Deployment\ConsumeSubscriptionFeaturesObserver::class,
        //        ]);
        //

        \App\Models\Server\Firewall\Rule::observe([
            \App\Observers\Server\Firewall\SyncFirewallRuleObserver::class,
        ]);
    }
}
