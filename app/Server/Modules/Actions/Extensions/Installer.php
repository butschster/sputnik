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
     * {@inheritDoc}
     */
    public function callbacks(): array
    {
        return [
            ModuleInstalled::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function isValid(Module $module, Server $server, array $data = []): bool
    {
        return !$server->modules()->where('name', $module->key())->exists();
    }

    /**
     * {@inheritDoc}
     */
    public function scriptData(Module $module, Server $server, array $data = []): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function databaseData(Module $module, Server $server, array $data = []): array
    {
        return [];
    }
}