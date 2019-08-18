<?php

namespace App\Providers;

use App\Contracts\Http\WebHooks\Manager as ManagerContract;
use App\Events\WebHooks\Ping;
use App\Events\WebHooks\Push;
use App\Http\WebHooks\Github;
use App\Http\WebHooks\Bitbucket;
use App\Http\WebHooks\Manager;
use Illuminate\Support\ServiceProvider;

class WebHooksServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $hooks = [
        Github\Ping::class => [
            Ping::class
        ],
        Github\Push::class => [
            Push::class
        ],
        Bitbucket\Push::class => [
            Push::class
        ]
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ManagerContract::class, function () {
            return new Manager(
                $this->app, $this->hooks
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
