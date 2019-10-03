<?php

namespace Module\Supervisor\Events\Daemon;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Module\Supervisor\Models\Daemon;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Daemon
     */
    public $daemon;

    /**
     * @param Daemon $daemon
     */
    public function __construct(Daemon $daemon)
    {
        $this->daemon = $daemon;
    }
}