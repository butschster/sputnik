<?php

namespace App\Scripts\Tools;

use App\Exceptions\Scrpits\ConfigurationNotFoundException;
use App\Models\Server\Site;

class WebServerConfigurator extends Configurator
{
    /**
     * @return string
     */
    public function type(): string
    {
        return $this->server->webserver_type;
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function availableTypes(): array
    {
        return config('configurations.webserver', []);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function install(): string
    {
        return $this->render('tools.webserver.' . $this->type() . '.install');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function uninstall(): string
    {
        return $this->render('tools.webserver.' . $this->type() . '.uninstall');
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function restart(): string
    {
        return $this->render('tools.webserver.' . $this->type() . '.restart');
    }

    /**
     * @param Site $site
     *
     * @return string
     * @throws \Throwable
     */
    public function createSite(Site $site): string
    {
        return $this->render('tools.webserver.' . $this->type() . '.site', compact('site'));
    }

    /**
     * @throws ConfigurationNotFoundException
     */
    protected function checkRequirements(): void
    {
        if (!in_array($this->type(), $this->availableTypes())) {
            throw new ConfigurationNotFoundException(
                "Configuration for given webserver type [{$this->type()}}] not found"
            );
        }
    }
}
