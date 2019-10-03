<?php

namespace Module\OpenVPN\Observers\Client;

use Module\OpenVPN\Models\Client;
use Module\OpenVPN\OpenVPNClientService;

class SyncUserObserver
{
    /**
     * @var OpenVPNClientService
     */
    protected $service;

    /**
     * @param OpenVPNClientService $service
     */
    public function __construct(OpenVPNClientService $service)
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
