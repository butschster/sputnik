<?php

namespace Domain\Site\Scripts;

use Domain\Site\Contracts\Entities\Processor;
use Domain\Site\Contracts\Entities\WebServer;
use Domain\Site\ValueObjects\Site;
use Domain\SSH\Script;

class CreateConfiguration extends Script
{
    /**
     * @var WebServer
     */
    protected $webServer;

    /**
     * @var Processor
     */
    protected $processor;

    /**
     * @var Site
     */
    protected $site;

    /**
     * @param WebServer $webServer
     * @param Processor $processor
     * @param Site $site
     */
    public function __construct(WebServer $webServer, Processor $processor, Site $site)
    {
        $this->webServer = $webServer;
        $this->processor = $processor;
        $this->site = $site;
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     * @throws \Throwable
     */
    public function getScript(): string
    {
        return view('scripts.server.site.configuration.create', [
            'webserver' => $this->webServer,
            'processor' => $this->processor,
            'site' => $this->site,
        ])->render();
    }
}