<?php

namespace App\Listeners\Server\Site\WebHooks;

use App\Events\WebHooks\Push;
use App\Jobs\Server\Site\Deploy;
use Illuminate\Support\Facades\Gate;

class DeploySite
{
    /**
     * @param Push $event
     */
    public function handle(Push $event)
    {
        if (!Gate::allows('push-deploy', $event->site)) {
            return;
        }

        dispatch(
            new Deploy($event->site)
        );
    }
}