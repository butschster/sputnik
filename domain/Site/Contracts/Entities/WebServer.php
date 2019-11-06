<?php

namespace Domain\Site\Contracts\Entities;

use App\Models\Server;
use Domain\Site\ValueObjects\Site;
use Domain\SSH\Contracts\Script;

interface WebServer
{
    /**
     * Get web server key
     *
     * @return string
     */
    public function key(): string;

    /**
     * Get web server name
     *
     * @return string
     */
    public function name(): string;

    /**
     * Get script for site creation
     *
     * @param Processor $processor
     * @param Site $site
     * @return Script
     */
    public function createScript(Processor $processor, Site $site): string;

    /**
     * Get script for site delete
     *
     * @param Processor $processor
     * @param Site $site
     * @return string
     */
    public function deleteScript(Processor $processor, Site $site): string;

    /**
     * Get script for web server restart
     *
     * @return string
     */
    public function restartScript(): string;
}