<?php

namespace App\Contracts\Server;

interface OpenVPNServerConfiguration extends ServerConfiguration
{
    /**
     * Get openVPN port
     *
     * @return int
     */
    public function port(): int;

    /**
     * Get the EasyRSA Variables
     *
     * @return array
     */
    public function vars(): array;
}