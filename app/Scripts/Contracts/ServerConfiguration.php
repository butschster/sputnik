<?php

namespace App\Scripts\Contracts;

use App\Utils\SSH\ValueObjects\PublicKey;

interface ServerConfiguration
{
    /**
     * Get PHP version
     *
     * @return string (56, 70, 71, 72, ....)
     */
    public function phpVersion(): string;

    /**
     * Get database type
     *
     * @return string (mysql, mysql8, mariadb, pqsql)
     */
    public function databaseType(): string;

    /**
     * Get database root password
     *
     * @return string
     */
    public function databasePassword(): string;

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
    public function webServerType(): string;

    /**
     * Get list of nosql databases
     *
     * @see http://nosql-database.org/
     * @return array (redis, memcache, beanstalk, ...)
     */
    public function noSqlDatabases(): array;

    /**
     * Get available system users with root access
     *
     * @return array
     */
    public function systemUsers(): array;

    /**
     * Get public key
     *
     * @return PublicKey
     */
    public function publicKey(): PublicKey;

    /**
     * Get callback URL, which should be used to send message from remote server
     *
     * @param string $message
     * @return string
     */
    public function callbackUrl(string $message): string;
}
