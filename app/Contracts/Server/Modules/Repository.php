<?php

namespace App\Contracts\Server\Modules;

use App\Contracts\Server\Module;
use App\Exceptions\Server\ModuleNotFoundException;
use Illuminate\Support\Collection;

interface Repository
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
    public function collection(): Collection;
}
