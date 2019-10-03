<?php

namespace Module\OpenVPN\Events\Database;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Module\OpenVPN\Models\Client;

class Deleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Client
     */
    public $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}