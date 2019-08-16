<?php

namespace App\Observers\Server;

use App\Models\Server;

class ConsumeSubscriptionFeaturesObserver
{
    /**
     * @param Server $server
     */
    public function created(Server $server): void
    {
        $server->user->useFeature('server.create');
    }

    /**
     * @param Server $server
     */
    public function deleted(Server $server): void
    {
        $server->user->returnFeature('server.create');
    }
}
