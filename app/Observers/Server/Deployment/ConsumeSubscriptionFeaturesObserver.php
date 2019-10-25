<?php

namespace App\Observers\Server\Deployment;

use App\Models\Server\Deployment;

class ConsumeSubscriptionFeaturesObserver
{
    /**
     * @param Deployment $deployment
     */
    public function created(Deployment $deployment): void
    {
        $deployment->server->team->useFeature('server.deployments.run');
    }
}
