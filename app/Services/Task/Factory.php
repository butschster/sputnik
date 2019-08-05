<?php

namespace App\Services\Task;

use App\Models\Server;
use App\Services\Task\Contracts\Task;
use App\Utils\SSH\Contracts\Script;

class Factory
{
    /**
     * Create a new task instance with given script for server.
     *
     * @param Server $server
     * @param Script $script
     * @param array $options
     *
     * @return Task
     */
    public function createFromScript(Server $server, Script $script, array $options = []): Task
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
