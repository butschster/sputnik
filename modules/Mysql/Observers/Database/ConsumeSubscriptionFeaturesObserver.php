<?php

namespace Module\Mysql\Observers\Database;

use Module\Mysql\Models\Database;

class ConsumeSubscriptionFeaturesObserver
{
    /**
     * @param Database $database
     */
    public function created(Database $database): void
    {
        $database->server->team->useFeature('server.database.create');
    }

    /**
     * @param Database $database
     */
    public function deleted(Database $database): void
    {
        $database->server->team->returnFeature('server.database.create');
    }
}
