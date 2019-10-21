<?php

namespace App\Contracts\Server\Modules\Action;

use App\Contracts\Server\Module;
use App\Models\Server;

interface Extension
{
    /**
     * Check if action can be run
     *
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return bool
     */
    public function isValid(Module $module, Server $server, array $data = []): bool;

    /**
     * Data for script only
     *
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return array
     */
    public function scriptData(Module $module, Server $server, array $data = []): array;

    /**
     * Data that should be stored to database
     *
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return array
     */
    public function databaseData(Module $module, Server $server, array $data = []): array;
}