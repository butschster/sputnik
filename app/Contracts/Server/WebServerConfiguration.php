<?php

namespace App\Contracts\Server;

interface WebServerConfiguration extends ServerConfiguration
{
    /**
     * Get PHP version
     *
     * @return string (56, 70, 71, 72, ....)
     */
    public function phpVersion(): ?string;

    /**
     * Get database type
     *
     * @return string (mysql, mysql8, mariadb, pqsql)
     */
    public function databaseType(): ?string;

    /**
     * Get database root password
     *
     * @return string
     */
    public function databasePassword(): ?string;

    /**
     * Get database hosts
     *
     * @return array (127.0.0.1, localhost, ...)
     */
    public function databaseHosts(): array;

    /**
     * Get web server type
     *
     * @return string (nginx, caddy, apache)
     */
    public function webServerType(): ?string;

    /**
     * Get list of nosql databases
     *
     * @see http://nosql-database.org/
     * @return array (redis, memcache, beanstalk, ...)
     */
    public function noSqlDatabases(): array;
}
