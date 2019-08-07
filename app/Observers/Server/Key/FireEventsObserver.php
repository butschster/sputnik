<?php

namespace App\Observers\Server\Key;

use App\Events\Server\Key\AttachedToServer;
use App\Events\Server\Key\DetachedFromServer;
use App\Models\Server\Key;

class FireEventsObserver
{
    /**
     * @param Key $key
     */
    public function created(Key $key)
    {
        event(new AttachedToServer($key));
    }

    /**
     * @param Key $key
     */
    public function deleted(Key $key)
    {
        event(new DetachedFromServer($key));
    }
}