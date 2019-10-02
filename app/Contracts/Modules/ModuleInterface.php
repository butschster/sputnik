<?php

namespace App\Contracts\Modules;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Kernel as ConsoleKernel;

interface ModuleInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getNamespace(): string;

    /**
     * @param string|null $path
     *
     * @return string
     */
    public function getPath(string $path = ''): string;

    /**
     * @return string
     */
    public function getControllerNamespace(): string;
}
