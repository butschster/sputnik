<?php

namespace App\Scripts\Server\Callbacks;

use App\Contracts\Scripts\Callback;
use App\Contracts\Server\Modules\Registry;
use App\Events\Server\Module\Installed;
use App\Models\Server\Task;
use App\Server\Module;
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
     * @throws \App\Exceptions\Server\ModuleNotFoundException
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
