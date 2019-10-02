<?php

namespace App\Server\Modules;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Registry as RegistryContract;
use App\Exceptions\Server\ModuleNotFoundException;
use Illuminate\Support\Collection;

class Registry implements RegistryContract
{
    /**
     * Modules list
     * @var array
     */
    protected $modules = [];

    /**
     * Get keys of registered modules
     * @return array
     */
    public function getKeys(): array
    {
        return array_keys($this->modules);
    }

    /**
     * Register a new module
     *
     * @param Module $module
     */
    public function register(Module $module): void
    {
        $this->modules[$module->key()] = $module;
    }

    /**
     * Register a new module from array
     *
     * @param array $data
     */
    public function registerFromArray(array $data): void
    {
        $this->register(
            Builder::buildFromArray($data)
        );
    }

    /**
     * Check if module registered
     *
     * @param string $module
     *
     * @return bool
     */
    public function has(string $module): bool
    {
        return array_key_exists($module, $this->modules);
    }

    /**
     * Get module by key
     *
     * @param string $module
     *
     * @return Module
     * @throws ModuleNotFoundException
     */
    public function get(string $module): Module
    {
        if (!$this->has($module)) {
            throw new ModuleNotFoundException(
                sprintf('Module %s for server not found', $module)
            );
        }

        return $this->modules[$module];
    }

    /**
     * Get modules collection
     * @return Collection
     */
    public function modules(): Collection
    {
        return collect($this->modules);
    }
}
