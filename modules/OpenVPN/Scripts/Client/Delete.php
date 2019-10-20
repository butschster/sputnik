<?php

namespace Module\OpenVPN\Scripts\Client;

use App\Utils\SSH\Script;
use Module\OpenVPN\Models\Client;

class Delete extends Script
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
        return view('OpenVPN::scripts.client.delete', [
            'name' => $this->client->name,
        ])->render();
    }
}
