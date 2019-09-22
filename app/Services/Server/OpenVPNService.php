<?php

namespace App\Services\Server;

use App\Models\Server;
use App\Scripts\Server\OpenVPN\CreateClient;
use App\Scripts\Server\OpenVPN\DeleteClient;
use App\Scripts\Server\OpenVPN\GetClientConfig;
use App\Services\Task\Contracts\Task;

class OpenVPNService
{
    use Runnable;

    /**
     * Get client OpenVPN config
     *
     * @param Server\OpenVPN\Client $client
     * @return string
     */
    public function getClientConfig(Server\OpenVPN\Client $client): string
    {
        $this->setServer($client->server);

        return $this->run(new GetClientConfig($client))->output;
    }

    /**
     * Add a new user
     *
     * @param Server\OpenVPN\Client $client
     * @return Task
     */
    public function createClient(Server\OpenVPN\Client $client): Task
    {
        $this->setServer($client->server);
        $this->setOwner($client);

        return $this->runJob(new CreateClient($client));
    }

    /**
     * Revoke an existing user
     *
     * @param Server\OpenVPN\Client $client
     *
     * @return Task
     */
    public function deleteClient(Server\OpenVPN\Client $client): Task
    {
        $this->setServer($client->server);
        $this->setOwner($client);

        return $this->runJob(new DeleteClient($client));
    }
}