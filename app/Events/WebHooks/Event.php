<?php

namespace App\Events\WebHooks;

use App\Models\Server\Site;

abstract class Event
{
    /**
     * @var Site
     */
    public $site;

    /**
     * @param Site $site
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
    }
}