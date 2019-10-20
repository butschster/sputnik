<?php

namespace Module\Mysql\Scripts\Database;

use App\Utils\SSH\Script;
use Module\Mysql\Models\Database;
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
    protected $user;

    /**
     * @param User $user
     * @param string $database
     */
    public function __construct(User $user, string $database)
    {
        $this->database = $database;
        $this->user = $user;
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
            'user' => $this->user,
            'database' => $this->database
        ]);
    }
}
