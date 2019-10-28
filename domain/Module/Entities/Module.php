<?php

namespace Domain\Module\Entities;

use Domain\Module\Exceptions\InvalidModuleActionException;
use Domain\Module\Contracts\Entities\Action as ActionContract;
use Domain\Module\Exceptions\ModuleActionNotFoundException;
use App\Models\Server;
use Illuminate\Support\Arr;

abstract class Module implements \Domain\Module\Contracts\Entities\Module
{

    /**
     * {@inheritDoc}
     */
    public function meta(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function categories(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function conflicts(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function dependencies(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getAction(string $name): ActionContract
    {
        $action = Arr::get($this->actions(), $name);

        if (!$action) {
            throw new ModuleActionNotFoundException(
                sprintf('Action [%s] for module [%s] not found', $name, $this->title())
            );
        }

        if (!$action instanceof ActionContract) {
            throw new InvalidModuleActionException('Action should be instanced of [App\Contracts\Server\Modules\Action] interface');
        }

        return $action;
    }

    /**
     * {@inheritDoc}
     */
    public function hasAction(string $name): bool
    {
        return Arr::has($this->actions(), $name);
    }

    /**
     * {@inheritDoc}
     */
    public function runAction(string $name, Server $server, array $data = []): Server\Action
    {
        $action = $this->getAction($name);

        return $action->run($server, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function isInstalled(Server $server): bool
    {
        return $server->modules()->where('name', $this->key())->exists();
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

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->key();
    }
}
