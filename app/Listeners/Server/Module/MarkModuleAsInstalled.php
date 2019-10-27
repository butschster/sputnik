<?php

namespace App\Listeners\Server\Module;

use App\Models\Server\Module;
use Domain\Module\Events\Module\Installed;

class MarkModuleAsInstalled
{
    /**
     * @param Installed $event
     */
    public function handle(Installed $event)
    {
        /** @var Module $module */
        if ($module = $event->server->modules()->where('name', $event->module)->first()) {

            $module->markAsInstalled();

        }
    }
}
