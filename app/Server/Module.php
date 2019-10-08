<?php

namespace App\Server;

use App\Contracts\Server\Modules\Action;
use App\Exceptions\Server\InvalidModuleActionException;
use App\Exceptions\Server\ModuleActionNotFoundException;
use App\Models\Server;
use Illuminate\Support\Arr;

abstract class Module implements \App\Contracts\Server\Module
{

    /**
     * Get module meta
     *
     * @return array
     */
    public function meta(): array
    {
        return [];
    }

    /**
     * Get module categories
     * @return array
     */
    public function categories(): array
    {
        return [];
    }

    /**
     * Get module conflicts
     *
     * @return array
     */
    public function conflicts(): array
    {
        return [];
    }

    /**
     * Get module dependencies
     * @return array
     */
    public function dependencies(): array
    {
        return [];
    }

    /**
     * Get action by name
     *
     * @param string $name
     * @return Action
     */
    public function getAction(string $name): Action
    {
        $action = Arr::get($this->actions(), $name);

        if (!$action) {
            throw new ModuleActionNotFoundException(
                sprintf('Action [%s] for module [%s] not found', $name, $this->title())
            );
        }

        if (!$action instanceof Action) {
            throw new InvalidModuleActionException('Action should be instanced of [App\Contracts\Server\Modules\Action] interface');
        }

        return $action;
    }

    /**
     * Check if action exists
     *
     * @param string $name
     * @return bool
     */
    public function hasAction(string $name): bool
    {
        return Arr::has($this->actions(), $name);
    }

    /**
     * Run action on a specified Server
     *
     * @param string $name
     * @param Server $server
     * @param array $data
     * @return Server\Task
     * @throws \Throwable
     */
    public function runAction(string $name, Server $server, array $data = []): Server\Task
    {
        $action = $this->getAction($name);

        return $action->run($this, $server, $data);
    }

    /**
     * Get list of actions
     *
     * @return array
     */
    public function actions(): array
    {
        return [];
    }

    /**
     * Get the instance as an array.
     * @return array
     */
    public function toArray()
    {
        return [
            'title' => $this->title(),
            'key' => $this->key(),
            'categories' => $this->categories(),
            'dependencies' => $this->dependencies(),
            'conflicts' => $this->conflicts(),
            'actions' => collect($this->actions())->toArray(),
        ];
    }
}
