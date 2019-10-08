<?php

namespace App\Listeners\Server\Module;

use App\Events\Server\Module\ActionRan;
use App\Models\Server;

class CreateModuleWhenInstallActionWasRun
{
    public function handle(ActionRan $event)
    {
        if ($event->action->key() === 'install') {
            $event->server->modules()->create([
                'name' => $event->module->key(),
                'meta' => $event->data,
                'status' => Server\Module::STATUS_INSTALLING,
            ]);
        }
    }
}
