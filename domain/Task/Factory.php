<?php

namespace Domain\Task;

use App\Models\Server;
use Domain\Task\Contracts\Task;
use Domain\SSH\Contracts\Script;
use Illuminate\Database\Eloquent\Model;

class Factory
{
    /**
     * Create a new task instance with given script for server.
     *
     * @param Server $server
     * @param Script $script
     * @param array $options
     * @param Model|null $owner
     * @return Task
     */
    public function createFromScript(Server $server, Script $script, array $options = [], Model $owner = null): Task
    {
        if (!array_key_exists('timeout', $options)) {
            $options['timeout'] = $script->getTimeout();
        }

        return $this->createTask(
            $server, $script, $options, $owner
        );
    }

    /**
     * Create a new task
     *
     * @param Server $server
     * @param Script $script
     * @param array $options
     * @param Model $owner
     * @return Server\Task
     */
    protected function createTask(Server $server, Script $script, array $options, Model $owner = null): Server\Task
    {
        $task = new Server\Task([
            'name' => $script->getName(),
            'user' => $script->getUser(),
            'options' => $options,
            'script' => (string)$script,
            'output' => '',
        ]);

        $task->server()->associate($server);

        if (!is_null($owner)) {
            $task->owner()->associate($owner);
        }

        $task->save();

        return $task;
    }
}
