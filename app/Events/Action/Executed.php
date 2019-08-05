<?php

namespace App\Events\Action;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Lorisleiva\Actions\Action;

class Executed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Action
     */
    public $action;

    /**
     * This event fires when remover server sends callback
     *
     * @param Action $action
     */
    public function __construct(Action $action)
    {
        $this->action = $action;
    }
}
