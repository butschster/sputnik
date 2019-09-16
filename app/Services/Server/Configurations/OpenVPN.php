<?php

namespace App\Services\Server\Configurations;

use App\Contracts\Server\OpenVPNServerConfiguration;

class OpenVPN implements OpenVPNServerConfiguration
{
    use BaseServerConfiguration;

    /**
     * Get openVPN port
     *
     * @return int
     */
    public function port(): int
    {
        return $this->server->meta['openvpn_port'] ?? 1194;
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