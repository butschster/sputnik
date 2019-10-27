<?php

namespace Domain\Module;

use Domain\Module\Contracts\Entities\Module;
use Domain\Module\Contracts\Registry as RegistryContract;
use Domain\Module\Exceptions\ModuleNotFoundException;
use Domain\Module\Services\ModuleBuilderFromArray;
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
            (new ModuleBuilderFromArray($data))->build()
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
