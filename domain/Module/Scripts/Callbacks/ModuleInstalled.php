<?php

namespace Domain\Module\Scripts\Callbacks;

use Domain\Task\Contracts\Script\Callback;
use Domain\Module\Contracts\Registry;
use App\Models\Server\Task;
use Domain\Module\Events\Module\Installed;
use Domain\Module\Events\Module\Failed;
use Illuminate\Support\Arr;
use Log;

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

        Log::debug('Module installed', [
            'module' => $module
        ]);

        if ($task->isSuccessful()) {
            event(new Installed($task->server, $module));
        } else {
            event(new Failed($task->server, $module));
        }
    }
}
