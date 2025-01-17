<?php

namespace Module\Mysql;

use App\Models\Server\Record;
use App\Services\Server\Runnable;
use Domain\Task\Contracts\Task;
use Module\Mysql\Scripts\Database\Create;
use Module\Mysql\Scripts\Database\Drop;
use Module\Mysql\ValueObjects\Database;
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

        $rootPassword = $record->module->meta['password'];
        $databaseName = $record->meta['name'];
        $password = $record->meta['password'];

        return $this->runJob(
            new Create(
                $this->makeDatabaseValueObject($databaseName, $password),
                $this->makeRootUserValueObject($rootPassword)
            )
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

        $rootPassword = $record->module->meta['password'];
        $databaseName = $record->meta['name'];
        $password = $record->meta['password'];

        return $this->runJob(
            new Drop(
                $this->makeDatabaseValueObject($databaseName, $password),
                $this->makeRootUserValueObject($rootPassword)
            )
        );
    }

    /**
     * @param $databaseName
     * @param $password
     * @return Database
     */
    protected function makeDatabaseValueObject($databaseName, $password): Database
    {
        return new Database(
            $databaseName,
            new User($databaseName, $password, [$databaseName . '.*'])
        );
    }

    /**
     * @param $password
     * @return User
     */
    protected function makeRootUserValueObject($password): User
    {
        return new User('root', $password);
    }
}
