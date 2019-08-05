<?php

namespace App\Http\Actions;

use App\Events\Action\Executed;
use App\Exceptions\Actions\ActionNotFoundException;
use App\Http\Actions\Contracts\Manager as ManagerContract;
use Illuminate\Http\Response;

class Manager implements ManagerContract
{
    /**
     * @var array
     */
    protected $actions;

    /**
     * @param array $actions
     */
    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    /**
     * Run action
     *
     * @param string $action
     * @param array $attributes
     *
     * @return Response|null
     */
    public function runAction(string $action, array $attributes = []): ?Response
    {
        if (!isset($this->actions[$action])) {
            throw new ActionNotFoundException(404, "Request action [{$action}] not found.");
        }

        $class = $this->actions[$action];

        $action = (new $class($attributes));

        event(new Executed($action));

        return $action->run();
    }
}
