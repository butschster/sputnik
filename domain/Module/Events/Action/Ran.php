<?php

namespace Domain\Module\Events\Action;

use Domain\Module\Contracts\Entities\Action;
use Domain\Module\Contracts\Entities\Module;
use App\Models\Server;

class Ran
{
    /**
     * @var Server
     */
    public $server;

    /**
     * @var Module
     */
    public $module;

    /**
     * @var Action
     */
    public $action;

    /**
     * @var array
     */
    public $data;

    /**
     * @param Server $server
     * @param Module $module
     * @param Action $action
     * @param array $data
     */
    public function __construct(Server $server, Module $module, Action $action, array $data)
    {
        $this->server = $server;
        $this->module = $module;
        $this->action = $action;
        $this->data = $data;
    }
}