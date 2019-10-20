<?php

namespace App\Providers;

use App\Models\Server;
use App\Models\User;
use App\Policies\Server as ServerPolicies;
use App\Policies\ServerPolicy;
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
        Server\Record::class => ServerPolicies\RecordPolicy::class,
        Server\Site::class => ServerPolicies\SitePolicy::class,
        Server\User::class => ServerPolicies\UserPolicy::class,
        Server\Task::class => ServerPolicies\TaskPolicy::class,
        Server\Firewall\Rule::class => ServerPolicies\FirewallPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPassport();
    }

    protected function registerPassport(): void
    {
        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
