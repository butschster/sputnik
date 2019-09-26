<?php

namespace App\Listeners\Server\Module;

use App\Events\Server\Module\Installed;
use App\Models\Server\Module;

class MarkModuleAsInstalled
{
    /**
     * @param Installed $event
     */
    public function handle(Installed $event)
    {
        $event->server->modules()->where('name', $event->module)->update([
            'status' => Module::STATUS_INSTALLED
        ]);

    }
}
