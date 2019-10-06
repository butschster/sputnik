<?php

namespace Module\Supervisor\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;
use Module\Supervisor\Policies\DaemonPolicy;
use Illuminate\Support\Facades\Gate;
use Module\Supervisor\Models\Daemon;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Module service providers
     *
     * @var array
     */
    protected $providers = [
        EventServiceProvider::class,
    ];

    public function register()
    {
        $this->registerServerModulesFromArray([
            [
                'key' => 'supervisor',
                'title' => 'Supervisor',
                'categories' => ['tools', 'daemon'],
                'actions' => [
                    'install' => [
                        'script_view' => 'Supervisor::scripts.install',
                        'extensions' => [
                            \App\Server\Modules\Actions\Extensions\Installer::class,
                        ],
                    ],
                    'uninstall' => 'Supervisor::scripts.uninstall',
                    'restart' => 'Supervisor::scripts.restart',
                    'start' => 'Supervisor::scripts.start',
                    'stop' => 'Supervisor::scripts.stop',
                ],
            ],
        ]);
    }

    public function boot()
    {
        parent::boot();

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }

        Gate::policy(Daemon::class, DaemonPolicy::class);
    }
}