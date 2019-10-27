<?php

namespace App\Modules;

use App\Contracts\Modules\ManagerInterface as ModulesManagerContract;
use App\Contracts\Modules\ModuleInterface;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Domain\Module\Contracts\Registry as RegistryContract;

abstract class ServiceProvider extends BaseServiceProvider
{
    /**
     * Module service providers
     *
     * @var array
     */
    protected $providers = [];

    /**
     * @return ModulesManagerContract
     */
    public function getManager(): ModulesManagerContract
    {
        return $this->app[ModulesManagerContract::class];
    }

    /**
     * @param string $name
     * @param string|null $namespace
     *
     * @return ModuleInterface
     */
    public function registerModule(string $name, string $namespace = null): ModuleInterface
    {
        return $this->getManager()->make($name, $namespace);
    }

    public function boot()
    {
        $this->registerModule(
            $this->moduleKey(),
            $this->moduleNamespace()
        );

        $this->registerModuleServiceProviders();
    }

    /**
     * Register server module
     *
     * @param array $modules
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function registerServerModules(array $modules): void
    {
        $registry = $this->app[RegistryContract::class];

        foreach ($modules as $module) {
            $registry->register(
                $this->app->make($module)
            );
        }
    }

    /**
     * Register server modules
     *
     * @param array $modules
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function registerServerModulesFromArray(array $modules): void
    {
        $registry = $this->app[RegistryContract::class];

        foreach ($modules as $module) {
            $registry->registerFromArray($module);
        }
    }

    /**
     * Register modules Service providers
     */
    protected function registerModuleServiceProviders(): void
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Get module unique key
     *
     * @return string
     */
    public function moduleKey(): string
    {
        return explode('\\', get_called_class())[1];
    }

    /**
     * Get module namespace
     *
     * @return string
     */
    public function moduleNamespace(): string
    {
        return collect(explode('\\', get_called_class()))
            ->take(2)
            ->implode('\\');
    }
}
