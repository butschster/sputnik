<?php

namespace App\Services\Task;

use App\Models\Server;
use App\Utils\Shell\Contracts\Script;

class Factory
{
    /**
     * Create a new task instance for server.
     *
     * @param Server $server
     * @param Script $script
     * @param array $options
     * @return Server\Task
     */
    public function createFromScript(Server $server, Script $script, array $options = []): Server\Task
    {
        if (!array_key_exists('timeout', $options)) {
            $options['timeout'] = $script->getTimeout();
        }

        return $server->tasks()->create([
            'name' => $script->getName(),
            'user' => $script->getUser(),
            'options' => $options,
            'script' => (string) $script,
            'output' => '',
        ]);
    }
}
