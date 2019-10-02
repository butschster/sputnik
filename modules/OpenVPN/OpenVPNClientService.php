<?php

namespace Module\OpenVPN;

use App\Services\Server\Runnable;
use App\Services\Task\Contracts\Task;
use Module\OpenVPN\Models\Client;
use Module\OpenVPN\Scripts\Client\Create;
use Module\OpenVPN\Scripts\Client\Delete;
use Module\OpenVPN\Scripts\Client\GetConfig;

class OpenVPNClientService
{
    use Runnable;

    /**
     * Get client OpenVPN config
     *
     * @param Client $client
     * @return string
     */
    public function getConfig(Client $client): string
    {
        $this->setServer($client->server);

        return $this->run(new GetConfig($client))->output;
    }

    /**
     * Add a new user
     *
     * @param Client $client
     * @return Task
     */
    public function create(Client $client): Task
    {
        $this->setServer($client->server);
        $this->setOwner($client);

        return $this->runJob(new Create($client));
    }

    /**
     * Revoke an existing user
     *
     * @param Server\OpenVPN\Client $client
     *
     * @return Task
     */
    public function delete(Server\OpenVPN\Client $client): Task
    {
        $this->setServer($client->server);
        $this->setOwner($client);

        return $this->runJob(new Delete($client));
    }
}