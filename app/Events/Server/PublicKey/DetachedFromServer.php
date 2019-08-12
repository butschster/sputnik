<?php

namespace App\Events\Server\PublicKey;

use App\Models\Server\PublicKey;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class DetachedFromServer
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var PublicKey
     */
    public $key;

    /**
     * This event fires when key detached from the server
     *
     * @param PublicKey $key
     */
    public function __construct(PublicKey $key)
    {
        $this->key = $key;
    }
}
