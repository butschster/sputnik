<?php

namespace App\Scripts\Tools;

use App\Exceptions\Scrpits\ConfigurationNotFoundException;
use App\Models\Server;

abstract class Configurator
{
    /**
     * @var Server
     */
    protected $server;

    /**
     * @param Server $server
     * @throws ConfigurationNotFoundException
     */
    public function __construct(Server $server)
    {
        $this->server = $server;

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
                'server' => $this->server,
                'users' => $this->server->getSystemUsers(),
                'configurator' => server_configurator($this->server),
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
        return callback_url('server.event', [
            'server_id' => $this->server->id, 'message' => $message,
        ], 10);
    }
}
