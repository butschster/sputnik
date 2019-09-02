<?php

namespace App\Models\Concerns;

use App\Utils\SSH\ValueObjects\PublicKey;

trait HasConfiguration
{
    /**
     * Get PHP version
     *
     * @return string (56, 70, 71, 72, ....)
     */
    public function phpVersion(): string
    {
        return $this->php_version;
    }

    /**
     * Get database type
     *
     * @return string (mysql, mysql8, mariadb, pqsql)
     */
    public function databaseType(): string
    {
        return $this->database_type;
    }

    /**
     * Get database root password
     *
     * @return string
     */
    public function databasePassword(): string
    {
        return $this->database_password;
    }

    /**
     * Get database hosts
     *
     * @return array (127.0.0.1, localhost, ...)
     */
    public function databaseHosts(): array
    {
        return [$this->ip, 'localhost'];
    }

    /**
     * Get web server type
     *
     * @return string (nginx, caddy, apache)
     */
    public function webServerType(): string
    {
        return $this->webserver_type;
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

    /**
     * Get available system users with root access
     *
     * @return array
     */
    public function systemUsers(): array
    {
        return $this->users()->where('is_system', true)->get()->all();
    }

    /**
     * Get callback URL, which should be used to send message from remote server
     *
     * @param string $message
     * @return string
     */
    public function callbackUrl(string $message): string
    {
        return callback_event($this->id, $message, 80, 10);
    }
}
