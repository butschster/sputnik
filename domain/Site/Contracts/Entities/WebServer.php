<?php

namespace Domain\Site\Contracts\Entities;

use Domain\Server\Contracts\Configuration;
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
     * @param Site $site
     * @return Script
     */
    //public function createScript(Configuration $configuration, Site $site): Script;

    /**
     * Get script for site delete
     *
     * @param Site $site
     * @return Script
     */
    //public function deleteScript(Site $site): Script;

    /**
     * Get script for restart site
     *
     * @param Site $site
     * @return Script
     */
    //public function restartScript(Site $site): Script;
}