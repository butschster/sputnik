<?php

namespace App\Services\Server;

use App\Models\Server;
use App\Services\Task\Contracts\Task;
use App\Services\Task\ExecutorService;
use App\Services\Task\Factory;
use App\Utils\SSH\Contracts\Script;

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
    public function setServer(Server $server)
    {
        $this->server = $server;
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
        $task = $this->tasksFactory->createFromScript($this->server, $script, $options);

        $this->executorService->run(
            $task
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
        $task = $this->tasksFactory->createFromScript($this->server, $script, $options);

        $this->executorService->runInBackground(
            $task
        );

        return $task;
    }
}
