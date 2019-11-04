<?php

namespace App\Listeners\Server\Module;

use Domain\Module\Events\Module\Failed;

class MarkModuleAsFailed
{
    /**
     * @param Failed $event
     */
    public function handle(Failed $event)
    {
        $event->server->getModule($event->module)->markAsFailed();
    }
}
