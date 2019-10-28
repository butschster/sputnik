<?php

namespace Domain\Site\Providers;

use Domain\Module\Contracts\Registry;
use Domain\Site\Configurator;
use Domain\Site\Contracts\Configurator as ConfiguratorContract;
use Illuminate\Support\ServiceProvider;

class ConfiguratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ConfiguratorContract::class, function () {
            return new Configurator(
                $this->app[Registry::class]
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
