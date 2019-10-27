<?php

namespace Domain\Module\Providers;

use Domain\Module\Contracts\Registry as RegistryContract;
use Domain\Module\Contracts\Entities\Module\Repository as RepositoryContract;
use Domain\Module\Entities\Module\Repository;
use Domain\Module\Registry;
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

        $this->app->singleton(RepositoryContract::class, function ($app) {
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
                        \Domain\Module\Entities\Action\Extensions\Installer::class,
                        \Domain\Module\Entities\Action\Extensions\BaseSettings::class,
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
