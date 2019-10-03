<?php

namespace Module\Supervisor\Observers\Daemon;

use Module\Supervisor\DaemonService;
use Module\Supervisor\Models\Daemon;

class SyncDaemonObserver
{
    /**
     * @var DaemonService
     */
    protected $service;

    /**
     * @param DaemonService $service
     */
    public function __construct(DaemonService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Daemon $daemon
     */
    public function created(Daemon $daemon): void
    {
        $this->service->start($daemon);
    }

    /**
     * @param Daemon $daemon
     */
    public function deleted(Daemon $daemon): void
    {
        $this->service->stop($daemon);
    }
}
