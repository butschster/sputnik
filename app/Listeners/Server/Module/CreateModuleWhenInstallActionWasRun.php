<?php

namespace App\Listeners\Server\Module;

use App\Models\Server;
use Domain\Module\Events\Action\Ran;

class CreateModuleWhenInstallActionWasRun
{
    public function handle(Ran $event)
    {
        if ($event->action->key() === 'install') {
            /** @var Server\Module $module */
            $module = $event->server->modules()->create([
                'name' => $event->module->key(),
                'meta' => $event->data,
            ]);

            $module->markAsInstalling();
        }
    }
}
