<?php

namespace App\Listeners\Server;

use App\Events\Server\Configured;
use Domain\Module\Jobs\InstallModules;
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

        dispatch(
            new InstallModules($event->server, $modules)
        );
    }
}
