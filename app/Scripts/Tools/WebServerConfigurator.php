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
        return $this->configuration->webServerType();
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
        return $this->render('tools.webserver.' . $this->type() . '.site.create', compact('site'));
    }

    /**
     * @param Site $site
     *
     * @return string
     * @throws \Throwable
     */
    public function deleteSite(Site $site): string
    {
        return $this->render('tools.webserver.' . $this->type() . '.site.delete', compact('site'));
    }

    /**
     * @throws ConfigurationNotFoundException
     */
    protected function checkRequirements(): void
    {
        if (!in_array($this->type(), $this->availableTypes())) {
            throw new ConfigurationNotFoundException(
                "Configuration for given webserver type [{$this->type()}] not found"
            );
        }
    }

    /**
     * Build config path for given site
     *
     * @param Site $site
     * @param string $path
     * @return string
     */
    public function configPath(Site $site, string $path = ''): string
    {
        return '/etc/nginx/configs/'.$site->domain.'/'.ltrim(trim($path), '/');
    }
}
