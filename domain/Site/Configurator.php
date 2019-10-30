<?php

namespace Domain\Site;

use App\Models\Server;
use Domain\Module\Contracts\Registry;
use Domain\Site\Contracts\Entities\Processor;
use Domain\Site\Contracts\Entities\WebServer;
use Domain\Site\Entities\ProxyProcessor;
use Domain\Site\Scripts\CreateConfiguration;
use Domain\Site\Scripts\DeleteConfiguration;
use Domain\Site\ValueObjects\Site;
use Domain\SSH\Script;
use Illuminate\Support\Collection;

class Configurator implements Contracts\Configurator
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Collection
     */
    private $webServers;

    /**
     * @var Collection
     */
    private $processors;

    /**
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
        $this->webServers = new Collection();
        $this->processors = new Collection();
    }

    /**
     * {@inheritDoc}
     */
    public function registerWebServer(WebServer $webServer): void
    {
        $this->webServers->put($webServer->key(), $webServer);
    }

    /**
     * {@inheritDoc}
     */
    public function registerProcessor(Processor $processor): void
    {
        $this->processors->put($processor->key(), $processor);
    }

    /**
     * {@inheritDoc}
     */
    public function getWebServersOptionsForServer(Server $server): Collection
    {
        return $this->webServers
            ->filter(function (WebServer $webServer) use($server) {
                return $this->registry->get($webServer->key())->isInstalled($server);
            })
            ->map(function(WebServer $webServer) {
                return [
                    'value' => $webServer->key(),
                    'label' => $webServer->name(),
                ];
            })
            ->values();
    }

    /**
     * {@inheritDoc}
     */
    public function getProcessorsOptionsForServer(Server $server): Collection
    {
        return $this->processors
            ->filter(function (Processor $processor) use($server) {
                return $this->registry->get($processor->key())->isInstalled($server);
            })
            ->map(function(Processor $processor) {
                return [
                    'value' => $processor->key(),
                    'label' => $processor->name(),
                ];
            })
            ->values();
    }

    /**
     * {@inheritDoc}
     */
    public function createConfiguration(string $webServer, ?string $processor = null, Site $site): Script
    {
        $webServer = $this->webServers->get($webServer);
        if ($processor) {
            $processor = $this->processors->get($processor);
        } else {
            $processor = new ProxyProcessor();
        }

        return new CreateConfiguration($webServer, $processor, $site);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteConfiguration(string $webServer, ?string $processor = null, Site $site): Script
    {
        $webServer = $this->webServers->get($webServer);
        if ($processor) {
            $processor = $this->processors->get($processor);
        } else {
            $processor = new ProxyProcessor();
        }

        return new DeleteConfiguration($webServer, $processor, $site);
    }
}