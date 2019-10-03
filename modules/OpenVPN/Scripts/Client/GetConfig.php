<?php

namespace Module\OpenVPN\Scripts\Client;

use App\Utils\SSH\Script;
use Module\OpenVPN\Models\Client;

class GetConfig extends Script
{
    /**
     * @var string
     */
    protected $name = 'Get OpenVPN client config';

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
        return sprintf('cat ~/%s.ovpn', $this->client->name);
    }
}
