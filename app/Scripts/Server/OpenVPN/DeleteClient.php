<?php

namespace App\Scripts\Server\OpenVPN;

use App\Models\Server\OpenVPN\Client;
use App\Utils\SSH\Script;

class DeleteClient extends Script
{
    /**
     * @var string
     */
    protected $name = 'Delete OpenVPN client config';

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
        return view('scripts.server.openvpn.delete_client', [
            'name' => $this->client->name,
        ])->render();
    }
}
