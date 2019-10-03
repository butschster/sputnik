<?php

namespace Module\Mysql\Scripts\Database;

use App\Utils\SSH\Script;
use Module\Mysql\Models\Database;

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
        return server_configurator($this->database->server)
            ->database()
            ->createDatabase($this->database);
    }
}
