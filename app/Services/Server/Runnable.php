<?php

namespace App\Services\Server;

use App\Models\Server;
use App\Services\Task\Contracts\Task;
use App\Services\Task\ExecutorService;
use App\Services\Task\Factory;
use App\Utils\SSH\Contracts\Script;
use Illuminate\Database\Eloquent\Model;

trait Runnable
{
    /**
     * Create instance for specific server
     *
     * @param Server $server
     *
     * @return Runnable
     */
    public static function factory(Server $server): self
    {
        $object = app(static::class);
        $object->setServer($server);

        return $object;
    }

    /**
     * @var Server
     */
    protected $server;

    /**
     * @var Model
     */
    protected $owner;

    /**
     * @var Factory
     */
    protected $tasksFactory;

    /**
     * @var ExecutorService
     */
    protected $executorService;

    /**
     * @param Factory $tasksFactory
     * @param ExecutorService $executorService
     */
    public function __construct(Factory $tasksFactory, ExecutorService $executorService)
    {
        $this->tasksFactory = $tasksFactory;
        $this->executorService = $executorService;
    }

    /**
     * @param Server $server
     */
    public function setServer(Server $server): void
    {
        $this->server = $server;
    }

    /**
     * @param Model $owner
     */
    public function setOwner(Model $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * Run the given script on the server.
     *
     * @param Script $script
     * @param array $options
     * @return Task
     */
    protected function run(Script $script, array $options = []): Task
    {
        $this->executorService->run(
            $task = $this->tasksFactory->createFromScript(
                $this->server, $script, $options, $this->owner
            )
        );

        return $task->refresh();
    }

    /**
     * Run the given script on the server by using nohup.
     * https://en.wikipedia.org/wiki/Nohup
     *
     * @param Script $script
     * @param array $options
     * @return Task
     * @throws \Throwable
     */
    protected function runInBackground(Script $script, array $options = []): Task
    {
        $this->executorService->runInBackground(
            $task = $this->tasksFactory->createFromScript(
                $this->server, $script, $options, $this->owner
            )
        );

        return $task->refresh();
    }
}
