<?php

namespace App\Observers\Server\Database;

use App\Events\Server\Database\Created;
use App\Events\Server\Database\Deleted;
use App\Models\Server\Database;

class FireEventsObserver
{
    /**
     * @param Database $database
     */
    public function created(Database $database): void
    {
        event(new Created($database));
    }

    /**
     * @param Database $database
     */
    public function deleted(Database $database): void
    {
        event(new Deleted($database));
    }
}
