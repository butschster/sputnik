<?php

namespace App\Listeners\Server;

use App\Events\Server\PublicKey\AttachedToServer;
use App\Jobs\Server\RunScript;
use App\Scripts\Server\AddPublicKey;

class AddPublicKeyToServer
{
    /**
     * Handle the event.
     *
     * @param AttachedToServer $event
     * @return void
     */
    public function handle(AttachedToServer $event): void
    {
        dispatch(new RunScript(
            $event->key->server,
            new AddPublicKey(
                'sputnik-' . $event->key->id,
                $event->key->content
            )
        ));
    }
}
