<?php

namespace Module\OpenVPN\Observers\Client;

use Module\OpenVPN\Events\Database\Created;
use Module\OpenVPN\Events\Database\Deleted;
use Module\OpenVPN\Models\Client;

class FireEventsObserver
{
    /**
     * @param Client $client
     */
    public function created(Client $client): void
    {
        event(new Created($client));
    }

    /**
     * @param Client $client
     */
    public function deleted(Client $client): void
    {
        event(new Deleted($client));
    }
}
