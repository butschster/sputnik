<?php

namespace App\Services\Server;

use App\Models\Server\Daemon;
use App\Scripts\Server\Supervisor\Restart;
use App\Scripts\Server\Supervisor\Start;
use App\Scripts\Server\Supervisor\Stop;
use App\Services\Task\Contracts\Task;

class SupervisorService
{
    use Runnable;

    /**
     * @param Daemon $daemon
     * @return Task
     */
    public function start(Daemon $daemon): Task
    {
        $this->setServer($daemon->server);
        $this->setOwner($daemon);

        return $this->runJob(new Start($daemon));
    }

    /**
     * @param Daemon $daemon
     * @return Task
     */
    public function stop(Daemon $daemon): Task
    {
        $this->setServer($daemon->server);
        $this->setOwner($daemon);

        return $this->runJob(new Stop($daemon));
    }

    /**
     * @param Daemon $daemon
     * @return Task
     */
    public function restart(Daemon $daemon): Task
    {
        $this->setServer($daemon->server);
        $this->setOwner($daemon);

        return $this->runJob(new Restart($daemon));
    }
}
