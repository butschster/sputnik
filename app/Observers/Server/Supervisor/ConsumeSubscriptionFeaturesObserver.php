<?php

namespace App\Observers\Server\Supervisor;

use App\Models\Server\Daemon;

class ConsumeSubscriptionFeaturesObserver
{
    /**
     * @param Daemon $daemon
     */
    public function created(Daemon $daemon): void
    {
        $daemon->server->user->useFeature('server.daemon.create');
    }

    /**
     * @param Daemon $daemon
     */
    public function deleted(Daemon $daemon): void
    {
        $daemon->server->user->returnFeature('server.daemon.create');
    }
}
