<?php

namespace App\Events\Server\Alert;

use App\Http\Resources\v1\Server\AlertResource;
use App\Models\Server\Alert;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class Created implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    /**
     * The alert instance.
     *
     * @var Alert
     */
    public $alert;

    /**
     * @param Alert $alert
     * @return void
     */
    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
    }

    /**
     * Get the user IDs affected by this alert.
     *
     * @return array
     */
    public function affectedIds(): array
    {
        return collect([$this->alert->server->team->users])->merge(
            $this->alert->server->user
        )->pluck('id')->unique()->all();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return new PrivateChannel('server.' . $this->alert->server->id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['alert' => AlertResource::make($this->alert)];
    }
}
