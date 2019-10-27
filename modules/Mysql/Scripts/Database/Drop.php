<?php

namespace Module\Mysql\Scripts\Database;

use Domain\SSH\Script;
use Module\Mysql\ValueObjects\Database;
use Module\Mysql\ValueObjects\User;

class Drop extends Script
{
    /**
     * @var Database
     */
    protected $database;

    /**
     * @var User
     */
    protected $root;

    /**
     * @param Database $database
     * @param User $root
     */
    public function __construct(Database $database, User $root)
    {
        $this->database = $database;
        $this->root = $root;
    }

    /**
     * @return string
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     *
     * @throws \Throwable
     */
    public function getScript(): string
    {
        return view('Mysql::scripts.mysql56.database.drop', [
            'database' => $this->database,
            'root' => $this->root
        ]);
    }
}
