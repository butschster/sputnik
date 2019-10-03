<?php

namespace Module\Supervisor\Observers\Daemon;

use Module\Supervisor\Models\Daemon;

class ConsumeSubscriptionFeaturesObserver
{
    /**
     * @param Daemon $daemon
     */
    public function created(Daemon $daemon): void
    {
        $daemon->server->team->useFeature('server.daemon.create');
    }

    /**
     * @param Daemon $daemon
     */
    public function deleted(Daemon $daemon): void
    {
        $daemon->server->team->returnFeature('server.daemon.create');
    }
}
