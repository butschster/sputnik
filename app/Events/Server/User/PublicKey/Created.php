<?php

namespace App\Events\Server\User\PublicKey;

use App\Models\Server\User\PublicKey;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var PublicKey
     */
    public $key;

    /**
     * Created constructor.
     *
     * @param PublicKey $key
     */
    public function __construct(PublicKey $key)
    {
        $this->key = $key;
    }
}
