<?php

namespace App\Listeners\Server;

use App\Events\Server\Module\Installed;
use Illuminate\Support\Arr;

class ClearModuleMetaInformation
{
    /**
     * @param Installed $event
     */
    public function handle(Installed $event)
    {
        $event->server->update([
            'meta' => Arr::except($event->server->meta, 'modules.' . $event->module),
        ]);
    }
}
