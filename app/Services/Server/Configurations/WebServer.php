<?php

namespace App\Services\Server\Configurations;

use App\Contracts\Server\WebServerConfiguration;
use App\Models\Server;
use App\Utils\SSH\ValueObjects\PrivateKey;
use App\Utils\SSH\ValueObjects\PublicKey;

class WebServer implements WebServerConfiguration
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
     * Get PHP version
     *
     * @return string (56, 70, 71, 72, ....)
     */
    public function phpVersion(): ?string
    {
        return $this->server->meta['php_version'] ?? null;
    }

    /**
     * Get database type
     *
     * @return string (mysql, mysql8, mariadb, pqsql)
     */
    public function databaseType(): ?string
    {
        return $this->server->meta['database_type'] ?? null;
    }

    /**
     * Get database root password
     *
     * @return string
     */
    public function databasePassword(): ?string
    {
        return $this->server->meta['database_password'] ?? null;
    }

    /**
     * Get database hosts
     *
     * @return array (127.0.0.1, localhost, ...)
     */
    public function databaseHosts(): array
    {
        return [$this->server->ip, 'localhost'];
    }

    /**
     * Get web server type
     *
     * @return string (nginx, caddy, apache)
     */
    public function webServerType(): ?string
    {
        return $this->server->meta['webserver_type'] ?? null;
    }

    /**
     * Get list of nosql databases
     *
     * @see http://nosql-database.org/
     * @return array (redis, memcache, beanstalk, ...)
     */
    public function noSqlDatabases(): array
    {
        return [];
    }

    public function toArray()
    {
        return [
            'php_version' => $this->phpVersion(),
            'database_type' => $this->databaseType(),
            'database_hosts' => $this->databaseHosts(),
            'webserver_type' => $this->webServerType(),
            'nosql_databases' => $this->noSqlDatabases(),
        ];
    }
}
