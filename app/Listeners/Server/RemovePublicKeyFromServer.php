<?php

namespace App\Listeners\Server;

use App\Events\Server\Key\DetachedFromServer;
use App\Jobs\Server\RunScript;
use App\Scripts\Server\RemovePublicKey;

class RemovePublicKeyFromServer
{
    /**
     * Handle the event.
     *
     * @param DetachedFromServer $event
     * @return void
     */
    public function handle(DetachedFromServer $event)
    {
        dispatch(new RunScript(
            $event->key->server,
            new RemovePublicKey(
                'sputnik-' . $event->key->id
            )
        ));
    }
}
