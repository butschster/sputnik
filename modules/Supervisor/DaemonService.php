<?php

namespace Module\Supervisor;

use App\Models\Server\Daemon;
use App\Services\Server\Runnable;
use App\Services\Task\Contracts\Task;
use Module\Supervisor\Scripts\Daemon\Restart;
use Module\Supervisor\Scripts\Daemon\Start;
use Module\Supervisor\Scripts\Daemon\Stop;

class DaemonService
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
