<?php

namespace App\Services\Server;

use App\Models\Server\Database;
use App\Scripts\Server\Database\Create;
use App\Scripts\Server\Database\Drop;
use App\Services\Task\Contracts\Task;

class DatabaseService
{
    use Runnable;

    /**
     * @param Database $database
     * @return Task
     */
    public function create(Database $database): Task
    {
        $this->setServer($database->server);
        $this->setOwner($database);

        return $this->runJob(new Create($database));
    }

    /**
     * @param Database $database
     * @return Task
     */
    public function delete(Database $database): Task
    {
        $this->setServer($database->server);
        $this->setOwner($database);

        return $this->runJob(new Drop($database));
    }
}
