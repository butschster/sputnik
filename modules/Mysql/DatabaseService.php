<?php

namespace Module\Mysql;

use App\Models\Server\Database;
use App\Services\Server\Runnable;
use App\Services\Task\Contracts\Task;
use Module\Mysql\Scripts\Database\Create;
use Module\Mysql\Scripts\Database\Drop;

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
