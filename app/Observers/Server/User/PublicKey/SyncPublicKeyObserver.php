<?php

namespace App\Observers\Server\User\PublicKey;

use App\Services\Server\SupervisorService;

class SyncPublicKeyObserver
{
    /**
     * @var SupervisorService
     */
    protected $service;

    /**
     * @param SupervisorService $service
     */
    public function __construct(SupervisorService $service)
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
