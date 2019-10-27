<?php

namespace App\Listeners\Server;

use App\Events\Server\Configured;
use Domain\Module\Jobs\Module\Install;
use Illuminate\Support\Arr;

class InstallModulesWhenServerWasConfigured
{
    /**
     * @param Configured $event
     */
    public function handle(Configured $event)
    {
        $modules = $event->server->meta('modules', []);

        foreach ($modules as $module) {
            dispatch(
                new Install($event->server, $module['key'], Arr::except($module, 'key'))
            );
        }
    }
}
