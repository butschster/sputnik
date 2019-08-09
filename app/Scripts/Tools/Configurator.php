<?php

namespace App\Scripts\Tools;

use App\Exceptions\Scrpits\ConfigurationNotFoundException;
use App\Scripts\Contracts\ServerConfiguration;

abstract class Configurator
{
    /**
     * @var ServerConfiguration
     */
    protected $configuration;

    /**
     * @param ServerConfiguration $configuration
     * @throws ConfigurationNotFoundException
     */
    public function __construct(ServerConfiguration $configuration)
    {
        $this->configuration = $configuration;

        $this->checkRequirements();
    }

    /**
     * @throws ConfigurationNotFoundException
     */
    abstract protected function checkRequirements(): void;

    /**
     * Get script path
     *
     * @param string $path
     * @return string
     */
    protected function scriptPath(string $path): string
    {
        return 'scripts.' . $path;
    }

    /**
     * Additional data for render
     *
     * @return array
     */
    protected function data(): array
    {
        return [];
    }

    /**
     * Get callback message
     *
     * @param string $path
     *
     * @return string
     */
    protected function callbackMessage(string $path): string
    {
        // By default it's current script path
        return str_replace('tools.', '', $path . '.finished');
    }

    /**
     * Render script view
     *
     * @param string $path
     * @param array $data
     * @return string
     * @throws \Throwable
     */
    protected function render(string $path, array $data = []): string
    {
        $data = array_merge(
            $this->data(), $data, [
                'config' => $this,
                'server' => $this->configuration,
                'users' => $this->configuration->systemUsers(),
                'configurator' => server_configurator($this->configuration),
            ]
        );

        return view($this->scriptPath('configurator'), [
            'script' => view($this->scriptPath($path), $data)->render(),
            'callback' => $this->generateCallbackUrl(
                $this->callbackMessage($path)
            ),
        ])->render();
    }

    /**
     * Generate callback URL for script
     *
     * @param string $message
     * @return string
     */
    protected function generateCallbackUrl(string $message): string
    {
        return $this->configuration->callbackUrl($message);
    }
}
