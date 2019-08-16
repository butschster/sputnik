<?php

namespace App\Observers\Server\Site;


use App\Models\Server\Site;

class ConsumeSubscriptionFeaturesObserver
{
    /**
     * @param Site $site
     */
    public function created(Site $site): void
    {
        $site->server->user->useFeature('server.site.create');
    }

    /**
     * @param Site $site
     */
    public function deleted(Site $site): void
    {
        $site->server->user->returnFeature('server.site.create');
    }
}
