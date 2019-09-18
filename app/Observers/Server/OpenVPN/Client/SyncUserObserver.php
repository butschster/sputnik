<?php

namespace App\Observers\Server\OpenVPN\Client;

use App\Models\Server\OpenVPN\Client;
use App\Services\Server\OpenVPNService;

class SyncUserObserver
{
    /**
     * @var OpenVPNService
     */
    protected $service;

    /**
     * @param OpenVPNService $service
     */
    public function __construct(OpenVPNService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Client $client
     */
    public function created(Client $client): void
    {
        $this->service->createClient($client);
    }

    /**
     * @param Client $client
     */
    public function deleted(Client $client): void
    {
        $this->service->deleteClient($client);
    }
}
