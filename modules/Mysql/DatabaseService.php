<?php

namespace Module\Mysql;

use App\Models\Server\Record;
use App\Services\Server\Runnable;
use App\Services\Task\Contracts\Task;
use Module\Mysql\Models\Database;
use Module\Mysql\Scripts\Database\Create;
use Module\Mysql\Scripts\Database\Drop;
use Module\Mysql\ValueObjects\User;

class DatabaseService
{
    use Runnable;

    /**
     * @param Record $record
     * @return Task
     */
    public function create(Record $record): Task
    {
        $this->setServer($record->server);
        $this->setOwner($record);

        return $this->runJob(
            new Create($record)
        );
    }

    /**
     * @param Record $record
     * @return Task
     */
    public function delete(Record $record): Task
    {
        $this->setServer($record->server);
        $this->setOwner($record);

        return $this->runJob(
            new Drop(
                new User('root', 'password'),
                $record->meta->name
            )
        );
    }
}
