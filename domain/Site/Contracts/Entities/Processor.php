<?php

namespace Domain\Site\Contracts\Entities;

use Domain\Site\ValueObjects\Site;

interface Processor
{
    /**
     * Get processor key
     *
     * @return string
     */
    public function key(): string;

    /**
     * Get processor name
     *
     * @return string
     */
    public function name(): string;

    /**
     * Create script for webserver site configuration
     *
     * @param string $webserver
     *
     * @return string
     */
    public function createScriptForWebServer(string $webserver, Site $site): string;

    /**
     * @return string
     */
    public function restartScript(): string;
}