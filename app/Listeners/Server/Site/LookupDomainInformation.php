<?php

namespace App\Listeners\Server\Site;

use App\Events\Server\Site\Created;
use App\Jobs\Server\Site\LookupDomain;

class LookupDomainInformation
{
    /**
     * @param Created $event
     */
    public function handle(Created $event)
    {
        dispatch(
            new LookupDomain($event->site)
        );
    }
}