<?php

namespace Module\OpenVPN\Providers;

use App\Modules\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Gate;
use Module\OpenVPN\Models\Client;
use Module\OpenVPN\Policies\ClientPolicy;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerServerModulesFromArray([
            [
                'key' => 'openvpn',
                'title' => 'OpenVPN',
                'categories' => ['tools', 'vpn'],
                'actions' => [
                    'install' => [
                        'script_view' => 'OpenVPN::scripts.install',
                        'extensions' => [
                            \App\Server\Modules\Actions\Extensions\Installer::class,
                            \Module\OpenVPN\OpenVPNSettings::class
                        ],
                    ],
                    'uninstall' => 'OpenVPN::scripts.uninstall',
                    'restart' => 'OpenVPN::scripts.restart',
                    'start' => 'OpenVPN::scripts.start',
                    'stop' => 'OpenVPN::scripts.stop',
                ],
            ],
        ]);
    }

    public function boot()
    {
        parent::boot();

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }

        Gate::policy(Client::class, ClientPolicy::class);
    }
}