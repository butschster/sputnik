<?php

namespace App\Contracts\Server\Modules;

use App\Contracts\Server\Module;
use App\Exceptions\Server\ModuleNotFoundException;
use Illuminate\Support\Collection;

interface Registry
{
    /**
     * Get keys of registered modules
     * @return array
     */
    public function getKeys(): array;

    /**
     * Register a new module
     *
     * @param Module $module
     */
    public function register(Module $module): void;

    /**
     * Register a new module from array
     *
     * @param array $data
     */
    public function registerFromArray(array $data): void;

    /**
     * Check if module registered
     *
     * @param string $module
     *
     * @return bool
     */
    public function has(string $module): bool;

    /**
     * Get module by key
     *
     * @param string $module
     *
     * @return Module
     * @throws ModuleNotFoundException
     */
    public function get(string $module): Module;

    /**
     * Get modules collection
     *
     * @return Collection
     */
    public function modules(): Collection;
}
