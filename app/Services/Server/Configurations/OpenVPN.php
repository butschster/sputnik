<?php

namespace App\Services\Server\Configurations;

use App\Contracts\Server\OpenVPNServerConfiguration;
use App\Models\Server;

class OpenVPN implements OpenVPNServerConfiguration
{
    use BaseServerConfiguration;

    /**
     * @var Server
     */
    protected $server;

    /**
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Get openVPN dns servers
     *
     * @return array
     */
    public function dns(): array
    {
        $dns = $this->server->meta['dns'] ?? null;

        switch ($dns) {
            case 'google':
                return [
                    '8.8.8.8',
                    '8.8.4.4'
                ];
            case 'opendns':
                return [
                    '208.67.222.222',
                    '208.67.220.220'
                ];
            case 'verisign':
                return [
                    '64.6.64.6',
                    '64.6.65.6'
                ];
        }

        return [];
    }

    /**
     * Get openVPN port
     *
     * @return int
     */
    public function port(): int
    {
        return $this->server->meta['vpn_port'] ?? 1194;
    }

    /**
     * Get openVPN protocol
     *
     * @return string
     */
    public function protocol(): string
    {
        return $this->server->meta['vpn_protocol'] ?? 'udp';
    }

    /**
     * Get the EasyRSA Variables
     *
     * @return array
     */
    public function vars(): array
    {
        return [
            'EASYRSA_REQ_COUNTRY' => 'US',
            'EASYRSA_REQ_PROVINCE' => 'NewYork',
            'EASYRSA_REQ_CITY' => 'New York City',
            'EASYRSA_REQ_ORG' => 'DigitalOcean',
            'EASYRSA_REQ_EMAIL' => 'admin@example.com',
            'EASYRSA_REQ_OU' => 'Community'
        ];
    }
}