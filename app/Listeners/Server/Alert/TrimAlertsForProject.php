<?php

namespace App\Listeners\Server\Alert;

use App\Events\Server\Alert\Created;

class TrimAlertsForProject
{
    /**
     * Handle the event.
     *
     * @param  Created  $event
     * @return void
     */
    public function handle(Created $event)
    {
        $alerts = $event->alert->server->alerts()->get();

        if (count($alerts) > 30) {
            $alerts->slice(30 - count($alerts))->each->delete();
        }
    }
}
