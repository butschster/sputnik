<?php

namespace Domain\Site\Entities;

use Domain\Site\Contracts\Entities\Processor;
use Domain\Site\ValueObjects\Site;

class ProxyProcessor implements Processor
{
    /**
     * {@inheritDoc}
     */
    public function key(): string
    {
        return 'proxy';
    }

    /**
     * {@inheritDoc}
     */
    public function name(): string
    {
        return 'Proxy processor';
    }

    /**
     * {@inheritDoc}
     */
    public function createScriptForWebServer(string $webserver, Site $site): string
    {
        return view('scripts.server.site.configuration.proxy', [
            'webserver' => $webserver,
            'site' => $site
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function restartScript(): string
    {
        return '';
    }
}