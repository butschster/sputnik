<?php

namespace App\Listeners\Server;

use App\Events\Server\KeysInstalled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfigureServer
{
    /**
     * @param KeysInstalled $event
     */
    public function handle(KeysInstalled $event)
    {
        dispatch(
            new \App\Jobs\Server\ConfigureServer($event->server)
        );
    }
}
