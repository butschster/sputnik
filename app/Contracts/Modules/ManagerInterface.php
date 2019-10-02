<?php

namespace App\Contracts\Modules;

use App\Console\Kernel as ConsoleKernel;
use App\Modules\ModulesCollection;
use Illuminate\Console\Scheduling\Schedule;

interface ManagerInterface
{
    /**
     * @return string
     */
    public function basePath(): string;

    /**
     * @param string $name
     * @param string|null $namespace
     *
     * @return ModuleInterface
     */
    public function make(string $name, string $namespace = null): ModuleInterface;

    /**
     * @param ModuleInterface $module
     *
     * @return ModuleInterface
     */
    public function register(ModuleInterface $module): ModuleInterface;

    /**
     * @return ModulesCollection|ModuleInterface[]
     */
    public function getModules(): ModulesCollection;
}
