<?php

namespace App\Observers\Server\User\PublicKey;

use App\Events\Server\User\PublicKey\Created;
use App\Events\Server\User\PublicKey\Deleted;
use App\Models\Server\User\PublicKey;

class FireEventsObserver
{
    /**
     * @param PublicKey $key
     */
    public function created(PublicKey $key): void
    {
        event(new Created($key));
    }

    /**
     * @param PublicKey $key
     */
    public function deleted(PublicKey $key): void
    {
        event(new Deleted($key));
    }
}
