<?php

namespace App\Providers;

use App\Models\Server;
use App\Models\User;
use App\Policies\ServerCronJobPolicy;
use App\Policies\ServerDaemonPolicy;
use App\Policies\ServerDatabasePolicy;
use App\Policies\ServerFirewallPolicy;
use App\Policies\ServerPublicKeyPolicy;
use App\Policies\ServerPolicy;
use App\Policies\ServerSitePolicy;
use App\Policies\ServerTaskPolicy;
use App\Policies\ServerUserPolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        User\Team::class => TeamPolicy::class,
        Server::class => ServerPolicy::class,
        Server\CronJob::class => ServerCronJobPolicy::class,
        Server\Site::class => ServerSitePolicy::class,
        Server\Database::class => ServerDatabasePolicy::class,
        Server\Daemon::class => ServerDaemonPolicy::class,
        Server\User::class => ServerUserPolicy::class,
        Server\Task::class => ServerTaskPolicy::class,
        Server\Firewall\Rule::class => ServerFirewallPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(15));

        Passport::refreshTokensExpireIn(now()->addDays(30));

        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
