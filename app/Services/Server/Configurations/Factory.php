<?php

namespace App\Services\Server\Configurations;

use App\Contracts\Server\ServerConfiguration;
use App\Exceptions\Server\ConfigurationException;
use App\Models\Server;

class Factory
{
    /**
     * @param Server $server
     *
     * @return ServerConfiguration
     */
    public static function create(Server $server): ServerConfiguration
    {
        switch ($server->type) {
            case 'webserver':
                return new WebServer($server);
            case 'openvpn':
                return new OpenVPN($server);
        }

        throw new ConfigurationException('Configuration for given type not found');
    }
}
