<?php

namespace App\Listeners\Server\Module;

use App\Contracts\Server\Modules\Registry;
use App\Events\Server\Module\Installed;

class FireModuleEventsWhenItInstalled
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
     * @param Installed $event
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function handle(Installed $event)
    {
        $this->registry->get($event->module);
    }
}