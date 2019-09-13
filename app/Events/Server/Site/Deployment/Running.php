<?php

namespace App\Events\Server\Site\Deployment;

use App\Models\Server\Site\Deployment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Running implements ShouldBroadcast
{
    /**
     * @var Deployment
     */
    public $deployment;

    /**
     * @param Deployment $deployment
     */
    public function __construct(Deployment $deployment)
    {
        $deployment->unsetRelation('site');
        $this->deployment = $deployment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return new Channel('site.'.$this->deployment->server_site_id);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'deployment';
    }
}
