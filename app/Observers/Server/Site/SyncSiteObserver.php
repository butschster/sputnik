<?php

namespace App\Observers\Server\Site;

use App\Models\Server\Site;
use App\Services\Server\Site\ConfiguratorService;

class SyncSiteObserver
{
    /**
     * @var ConfiguratorService
     */
    protected $service;

    /**
     * @param ConfiguratorService $service
     */
    public function __construct(ConfiguratorService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Site $site
     */
    public function created(Site $site): void
    {
        $this->service->create($site);
    }

    /**
     * @param Site $site
     */
    public function deleted(Site $site): void
    {
        $this->service->delete($site);
    }
}
