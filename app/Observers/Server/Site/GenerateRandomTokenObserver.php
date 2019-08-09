<?php

namespace App\Observers\Server\Site;

use App\Models\Server\Site;
use Illuminate\Support\Str;

class GenerateRandomTokenObserver
{
    /**
     * Generate random string
     *
     * @param Site $site
     */
    public function creating(Site $site)
    {
        $site->token = Str::random(40);
    }
}
