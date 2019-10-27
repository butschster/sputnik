<?php

namespace Domain\Module\Scripts\Callbacks;

use Domain\Task\Contracts\Script\Callback;
use Domain\Module\Contracts\Registry;
use App\Models\Server\Task;
use Domain\Module\Events\Module\Installed;
use Illuminate\Support\Arr;

class ModuleInstalled implements Callback
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * When the task "Configuring Web Server" is finished it runs this callback
     * and the server changes status to finished
     *
     * @param Task $task
     *
     * @return void
     * @throws \Domain\Module\Exceptions\ModuleNotFoundException
     */
    public function handle(Task $task): void
    {
        $module = Arr::get($task->options(), 'module');

        if (!$module) {
            return;
        }

        event(new Installed($task->server, $module));
    }
}
