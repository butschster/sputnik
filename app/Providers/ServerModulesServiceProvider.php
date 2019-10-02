<?php

namespace App\Providers;

use App\Contracts\Server\Modules\Registry as RegistryContract;
use App\Contracts\Server\Modules\Repository as RepositoryContract;
use App\Server\Module;
use App\Server\Modules\Action;
use App\Server\Modules\BaseSettings;
use App\Server\Modules\PHP;
use App\Server\Modules\Webserver;
use App\Server\Modules\Database;
use App\Server\Modules\Repository;
use App\Server\Modules\Security;
use App\Server\Modules\Javascript;
use App\Server\Modules\Registry;
use App\Server\Modules\Tools;
use Illuminate\Support\ServiceProvider;

class ServerModulesServiceProvider extends ServiceProvider
{
    /**
     * Available server modules
     *
     * @var array
     */
    protected $modules = [
        //
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RegistryContract::class, function ($app) {
            $registry = new Registry();

            foreach ($this->modules as $module) {
                $registry->register(
                    $app->make($module)
                );
            }

            $registry->registerFromArray($this->baseSettingsModule());

            return $registry;
        });

        $this->app->singleton(RepositoryContract::class, function () {
            return new Repository(
                $this->app[RegistryContract::class]
            );
        });
    }

    protected function baseSettingsModule(): array
    {
        return [
            'key' => 'base_settings',
            'title' => 'Base settings',
            'categories' => ['base'],
            'actions' => [
                'install' => [
                    'script_view' => 'scripts.server.configuration.partials.base_settings',
                    'extensions' => [
                        \App\Server\Modules\Actions\Extensions\Installer::class,
                        \App\Server\Modules\Actions\Extensions\BaseSettings::class,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    public function boot()
    {

    }
}
