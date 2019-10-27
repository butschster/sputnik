<?php

namespace Module\Supervisor;

use App\Models\Server\Record;
use App\Services\Server\Runnable;
use Domain\Task\Contracts\Task;
use Module\Supervisor\Scripts\Daemon\Restart;
use Module\Supervisor\Scripts\Daemon\Start;
use Module\Supervisor\Scripts\Daemon\Stop;

class DaemonService
{
    use Runnable;

    /**
     * @param Record $record
     * @return Task
     */
    public function start(Record $record): Task
    {
        $this->setServer($record->server);
        $this->setOwner($record);

        return $this->runJob(
            new Start($record)
        );
    }

    /**
     * @param Record $record
     * @return Task
     */
    public function stop(Record $record): Task
    {
        $this->setServer($record->server);
        $this->setOwner($record);

        return $this->runJob(
            new Stop($record)
        );
    }

    /**
     * @param Record $record
     * @return Task
     */
    public function restart(Record $record): Task
    {
        $this->setServer($record->server);
        $this->setOwner($record);

        return $this->runJob(
            new Restart($record)
        );
    }
}
