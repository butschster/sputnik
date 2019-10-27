<?php

namespace Domain\Module\Entities\Action\Extensions;

use Domain\Module\Contracts\Entities\Action\Extension;
use Domain\Module\Contracts\Entities\Action\HasCallbacks;
use App\Models\Server;
use Domain\Module\Scripts\Callbacks\ModuleInstalled;
use Domain\Module\Contracts\Entities\Module;

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