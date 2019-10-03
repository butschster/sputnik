<?php

namespace Module\Mysql\Observers\Database;

use Module\Mysql\Events\Database\Created;
use Module\Mysql\Events\Database\Deleted;
use Module\Mysql\Models\Database;

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
