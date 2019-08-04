<?php

namespace App\Listeners\Server;

use App\Events\Server\Key\DetachedFromServer;
use App\Scripts\Server\RemovePublicKey;
use App\Services\Task\Factory;
use App\Services\Task\RunnerService;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemovePublicKeyFromServer implements ShouldQueue
{
    /**
     * @var Factory
     */
    protected $taskFactory;
    /**
     * @var RunnerService
     */
    protected $service;

    /**
     * @param Factory $taskFactory
     * @param RunnerService $service
     */
    public function __construct(Factory $taskFactory, RunnerService $service)
    {
        $this->taskFactory = $taskFactory;
        $this->service = $service;
    }
    /**
     * Handle the event.
     *
     * @param DetachedFromServer $event
     * @return void
     */
    public function handle(DetachedFromServer $event)
    {
        $task = $this->taskFactory->createFromScript(
            $event->server,
            new RemovePublicKey(
                'sputnik-' . $event->key->id
            )
        );

        $this->service->run($task);
    }
}
