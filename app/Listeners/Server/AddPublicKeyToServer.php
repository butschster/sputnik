<?php

namespace App\Listeners\Server;

use App\Events\Server\Key\AttachedToServer;
use App\Scripts\Server\AddPublicKey;
use App\Services\Task\Factory;
use App\Services\Task\RunnerService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddPublicKeyToServer implements ShouldQueue
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
     * @param AttachedToServer $event
     * @return void
     */
    public function handle(AttachedToServer $event)
    {
        $task = $this->taskFactory->createFromScript(
            $event->server,
            new AddPublicKey(
                'sputnik-' . $event->key->id,
                $event->key->content
            )
        );

        $this->service->run($task);
    }
}
