<?php

namespace App\Observers\Server\Supervisor;

use App\Events\Server\Supervisor\Created;
use App\Events\Server\Supervisor\Deleted;
use App\Models\Server\Daemon;

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
