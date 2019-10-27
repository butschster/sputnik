<?php

namespace App\Scripts\Server\Site;

use App\Models\Server\Site;
use Domain\SSH\Script;

class Create extends Script
{
    protected $name = 'Create a new site configuration';

    /**
     * @var Site
     */
    protected $site;

    /**
     * @param Site $site
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    /**
     * @return string
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     * @throws \Throwable
     */
    public function getScript(): string
    {
        $configurator = server_configurator($this->site->server);

        return $configurator->webserver()->createSite($this->site);
    }
}
