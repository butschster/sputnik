<?php

namespace App\Events\Server\Module;

use App\Models\Server;

class StatusChanged
{
    /**
     * @var Server\Module
     */
    public $module;

    /**
     * @param Server\Module $module
     */
    public function __construct(Server\Module $module)
    {
        $this->module = $module;
    }
}