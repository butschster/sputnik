<?php

namespace App\Scripts\Server\OpenVPN;

use App\Utils\SSH\Script;

class GetClientConfig extends Script
{
    /**
     * @var string
     */
    protected $name = 'Get OpenVPN client config';

    /**
     * @var string
     */
    protected $user;

    /**
     * @param string $user
     */
    public function __construct(string $user)
    {
        $this->user = $user;
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string
    {
        return sprintf('cat ~/%s.ovpn', $this->user);
    }
}
