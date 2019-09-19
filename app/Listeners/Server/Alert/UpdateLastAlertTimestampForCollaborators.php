<?php

namespace App\Listeners\Server\Alert;

use App\Events\Server\Alert\Created;
use App\Models\User;

class UpdateLastAlertTimestampForCollaborators
{
    /**
     * @param Created $event
     */
    public function handle(Created $event)
    {
        User::whereIn('id', $event->affectedIds())->update([
            'last_alert_received_at' => now()
        ]);
    }
}