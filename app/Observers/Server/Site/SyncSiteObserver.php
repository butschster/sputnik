<?php

namespace App\Observers\Server\Site;

use App\Models\Server\Site;
use Domain\Site\Services\ConfiguratorService;

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
        $this->service->create($site->refresh());
    }

    /**
     * @param Site $site
     */
    public function deleted(Site $site): void
    {
        $this->service->delete($site);
    }
}
