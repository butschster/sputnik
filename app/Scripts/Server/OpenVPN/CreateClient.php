<?php

namespace App\Scripts\Server\OpenVPN;

use App\Models\Server\OpenVPN\Client;
use App\Utils\SSH\Script;

class CreateClient extends Script
{
    /**
     * @var string
     */
    protected $name = 'Create OpenVPN client config';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string
    {
        return view('scripts.server.openvpn.add_client', [
            'name' => $this->client->name,
            'configuration' => $this->client->server->toConfiguration(),
        ])->render();
    }
}
