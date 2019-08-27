<?php

namespace App\Observers\Server\Event;

use App\Events\Server\Event\Created;
use App\Models\Server\Event;

class FireEventsObserver
{
    /**
     * @param Event $event
     */
    public function created(Event $event): void
    {
        event(new Created($event));
    }

}