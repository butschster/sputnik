<?php

namespace App\Server\Modules;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Repository as RepositoryContract;
use App\Exceptions\Server\ModuleNotFoundException;
use Illuminate\Support\Collection;

class Repository implements RepositoryContract
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
    public function collection(): Collection
    {
        return collect($this->modules);
    }
}
