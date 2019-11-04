<?php

namespace App\Listeners\Server\Module;

use App\Models\Server\Module;
use Domain\Module\Events\Module\Installed;
use Illuminate\Support\Facades\Log;

class MarkModuleAsInstalled
{
    /**
     * @param Installed $event
     */
    public function handle(Installed $event)
    {
        $event->server->getModule($event->module)->markAsInstalled();
    }
}
