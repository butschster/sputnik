<?php

namespace App\Scripts\Server\Database;

use App\Models\Server\Database;
use App\Utils\SSH\Script;

class Create extends Script
{
    /**
     * @var Database
     */
    protected $database;

    /**
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return string
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     *
     * @throws \Throwable
     */
    public function getScript(): string
    {
        $configurator = server_configurator($this->database->server);

        return $configurator->database()->createDatabase($this->database);
    }
}
