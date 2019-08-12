<?php

namespace App\Observers\Server\PublicKey;

use App\Events\Server\PublicKey\AttachedToServer;
use App\Events\Server\PublicKey\DetachedFromServer;
use App\Models\Server\PublicKey;

class FireEventsObserver
{
    /**
     * @param PublicKey $key
     */
    public function created(PublicKey $key): void
    {
        event(new AttachedToServer($key));
    }

    /**
     * @param PublicKey $key
     */
    public function deleted(PublicKey $key): void
    {
        event(new DetachedFromServer($key));
    }
}
