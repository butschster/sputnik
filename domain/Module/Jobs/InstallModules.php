<?php

namespace Domain\Module\Jobs;

use App\Models\Server;
use Domain\Module\Contracts\Entities\Module\Repository;
use Domain\Module\Contracts\Registry;
use Domain\Module\Jobs\Module\Install;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class InstallModules implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Server
     */
    public $server;

    /**
     * @var array
     */
    public $modules;

    /**
     * @param Server $server
     * @param array $modules
     */
    public function __construct(Server $server, array $modules)
    {
        $this->server = $server;
        $this->modules = $modules;
    }

    /**
     * @param Registry $registry
     */
    public function handle(Registry $registry)
    {
        $chain = [];
        foreach ($this->modules as $module) {
            try {
                $this->server->getModule($module['key']);
            } catch (ModelNotFoundException $e) {
                $chain[] = new Install($this->server, $module['key'], Arr::except($module, 'key'));
            }
        }

        $this->chain($chain);
    }
}
