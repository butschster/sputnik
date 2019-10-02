<?php

namespace App\Modules;

use App\Contracts\Modules\ManagerInterface;
use App\Contracts\Modules\ModuleInterface;
use Illuminate\Contracts\Foundation\Application;

class Manager implements ManagerInterface
{
    /**
     * @var ModulesCollection
     */
    protected $modules;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->modules = new ModulesCollection();
        $this->app = $application;
    }

    /**
     * @return string
     */
    public function basePath(): string
    {
        return $this->app->basePath().DIRECTORY_SEPARATOR.'modules';
    }

    /**
     * @param string $name
     * @param string|null $namespace
     *
     * @return ModuleInterface
     */
    public function make(string $name, string $namespace = null): ModuleInterface
    {
        return $this->register(
            new class($this->app, $name, $namespace) extends Module {}
        );
    }

    /**
     * @param ModuleInterface $module
     *
     * @return ModuleInterface
     */
    public function register(ModuleInterface $module): ModuleInterface
    {
        $this->modules->push($module);
        $this->app->register($module, true);

        return $module;
    }

    /**
     * @return ModulesCollection|Module[]
     */
    public function getModules(): ModulesCollection
    {
        return $this->modules;
    }
}
