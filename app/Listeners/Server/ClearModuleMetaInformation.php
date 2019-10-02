<?php

namespace App\Listeners\Server;

use App\Events\Server\Module\ActionRan;
use Illuminate\Support\Arr;

class ClearModuleMetaInformation
{
    /**
     * @param ActionRan $event
     */
    public function handle(ActionRan $event)
    {
        if ($event->action === 'install') {
            $event->server->update([
                'meta' => Arr::except($event->server->meta, 'modules.' . $event->module),
            ]);
        }
    }
}
