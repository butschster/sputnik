<?php

namespace Module\Supervisor\Observers\Daemon;

use Module\Supervisor\Events\Daemon\Created;
use Module\Supervisor\Events\Daemon\Deleted;
use Module\Supervisor\Models\Daemon;

class FireEventsObserver
{
    /**
     * @param Daemon $daemon
     */
    public function created(Daemon $daemon): void
    {
        event(new Created($daemon));
    }

    /**
     * @param Daemon $daemon
     */
    public function deleted(Daemon $daemon): void
    {
        event(new Deleted($daemon));
    }
}
