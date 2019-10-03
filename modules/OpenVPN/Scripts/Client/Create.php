<?php

namespace Module\OpenVPN\Scripts\Client;

use App\Utils\SSH\Script;
use Module\OpenVPN\Models\Client;

class Create extends Script
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
        return view('OpenVPN::scripts.clientc.create', [
            'name' => $this->client->name,
            'configuration' => $this->client->server->toConfiguration(),
        ])->render();
    }
}
