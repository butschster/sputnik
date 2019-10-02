<?php

namespace App\Server\Modules\Actions\Extensions;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Action\Extension;
use App\Contracts\Server\Modules\Action\HasCallbacks;
use App\Models\Server;
use App\Scripts\Server\Callbacks\ModuleInstalled;

class Installer implements Extension, HasCallbacks
{
    /**
     * @return array
     */
    public function callbacks(): array
    {
        return [
            ModuleInstalled::class,
        ];
    }

    /**
     * Check if action can be run
     *
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return bool
     */
    public function isValid(Module $module, Server $server, array $data = []): bool
    {
        return !$server->modules()->where('name', $module->key())->exists();
    }

    /**
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return array
     */
    public function data(Module $module, Server $server, array $data = []): array
    {
        return [];
    }
}