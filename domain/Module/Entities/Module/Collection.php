<?php

namespace Domain\Module\Entities\Module;

use App\Models\Server;
use App\Models\Server\Module;

class Collection
{
    /**
     * @param Server $server
     * @return static
     */
    public static function forServer(Server $server)
    {
        return new static($server->modules);
    }

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $modules;

    /**
     * @param \Illuminate\Support\Collection $modules
     */
    protected function __construct(\Illuminate\Support\Collection $modules)
    {
        $this->modules = $modules;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function keys(): \Illuminate\Support\Collection
    {
        return $this->modules->map(function (Module $module) {
            return $module->name;
        });
    }

    /**
     * @return Collection
     */
    public function installed(): self
    {
        return new static($this->modules->filter(function (Module $module) {
            return $module->status === Module::STATUS_INSTALLED;
        }));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function toModule(): \Illuminate\Support\Collection
    {
        return $this->modules->map(function (Module $module) {
            return $module->toModule();
        });
    }

    /**
     * @param string|array $categories
     *
     * @return Collection
     */
    public function filterByCategories(array $categories): self
    {
        return new static($this->modules->filter(function (Module $module) use ($categories) {
            return $module->belongsToCategories($categories);
        }));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function toCollection(): \Illuminate\Support\Collection
    {
        return $this->modules;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->modules->all();
    }
}