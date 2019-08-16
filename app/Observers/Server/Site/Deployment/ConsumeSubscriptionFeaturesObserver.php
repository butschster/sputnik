<?php

namespace App\Observers\Server\Site\Deployment;

use App\Models\Server\Site\Deployment;

class ConsumeSubscriptionFeaturesObserver
{
    /**
     * @param Deployment $deployment
     */
    public function created(Deployment $deployment): void
    {
        $deployment->site->server->user->useFeature('server.deployments');
    }
}
