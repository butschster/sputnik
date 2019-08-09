<?php

namespace App\Events\Server\Site;

use App\Models\Server;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Server\Site
     */
    public $site;

    /**
     * @param Server\Site $site
     */
    public function __construct(Server\Site $site)
    {
        $this->site = $site;
    }
}
