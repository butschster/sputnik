<?php

namespace App\Observers\Server\Site;

use App\Events\Server\Site\Created;
use App\Events\Server\Site\Deleted;
use App\Models\Server\Site;

class FireEventsObserver
{
    /**
     * @param Site $site
     */
    public function created(Site $site): void
    {
        event(new Created($site));
    }

    /**
     * @param Site $site
     */
    public function deleted(Site $site): void
    {
        event(new Deleted($site));
    }
}
