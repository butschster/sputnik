<?php

namespace App\Jobs\Server\Module;

use App\Contracts\Server\Modules\Registry;
use App\Contracts\Server\Modules\Repository;
use App\Models\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class Install implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Server
     */
    public $server;

    /**
     * @var string
     */
    public $module;

    /**
     * @var array
     */
    public $data;

    /**
     * @param Server $server
     * @param string $module
     * @param array $data
     */
    public function __construct(Server $server, string $module, array $data = [])
    {
        $this->server = $server;
        $this->module = $module;
        $this->data = $data;
    }

    /**
     * @param Repository $repository
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function handle(Repository $repository)
    {
        $repository->runAction($this->module, 'install', $this->server, $this->data);
    }
}
