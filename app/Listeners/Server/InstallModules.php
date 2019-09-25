<?php

namespace App\Listeners\Server;

use App\Events\Server\Configured;
use App\Jobs\Server\Module\Install;
use Illuminate\Support\Arr;

class InstallModules
{
    /**
     * @param Configured $event
     */
    public function handle(Configured $event)
    {
        $modules = $event->server->meta('modules', []);

        foreach ($modules as $module) {
            dispatch(
                new Install($event->server, $module['key'], $module['data'])
            );
        }

        $event->server->meta = Arr::except($event->server->meta, 'modules');
        $event->server->save();
    }
}
