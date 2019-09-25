<?php

namespace App\Server\Modules;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Configuration as ConfigurationContract;
use App\Jobs\Server\RunScript;
use App\Models\Server;
use App\Scripts\Server\CustomScript;

abstract class Configuration implements ConfigurationContract
{
    /**
     * @var Module
     */
    protected $module;

    /**
     * Configuration constructor.
     *
     * @param Module $module
     */
    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * @param Server $server
     *
     * @return bool
     */
    public function checkRequirements(Server $server): bool
    {
        return true;
    }

    /**
     * Get script path
     *
     * @param string $path
     *
     * @return string
     */
    protected function scriptPath(string $path): string
    {
        return 'scripts.server.modules.' . $path;
    }

    /**
     * Additional data for render
     *
     * @param Server $server
     *
     * @return array
     */
    protected function data(Server $server): array
    {
        return [];
    }

    /**
     * @param Server $server
     * @param array $data
     *
     * @return array
     */
    protected function prepareData(Server $server, array $data): array
    {
        return array_merge(
            $this->module->defaultSettings(),
            $this->data($server),
            $data
        );
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
        return $path . '.finished';
    }

    /**
     * Render script view
     *
     * @param Server $server
     * @param string $path
     * @param array $data
     *
     * @return string
     * @throws \Throwable
     */
    protected function render(Server $server, string $path, array $data = []): string
    {
        $data = array_merge(
            $data,
            [
                'config' => $this,
                'server' => $server,
                'users' => $server->toConfiguration()->systemUsers()
            ]
        );

        return view($this->scriptPath('configurator'), [
            'script' => view($this->scriptPath($path), $data)->render(),
            'callback' => $this->generateCallbackUrl($server, $this->callbackMessage($path)),
        ])->render();
    }

    /**
     * Generate callback URL for script
     *
     * @param Server $server
     * @param string $message
     *
     * @return string
     */
    protected function generateCallbackUrl(Server $server, string $message): string
    {
        return callback_event($server->id, $message, 80, 10);
    }

    /**
     * Run script on specified server
     *
     * @param Server $server
     * @param string $script
     * @param string $name
     *
     * @return Server\Task
     */
    protected function runScript(Server $server, string $script, string $name): Server\Task
    {
        return dispatch_now(
            new RunScript($server, new CustomScript($name, $script))
        );
    }

    /**
     * Restart module
     *
     * @param Server $server
     */
    public function restart(Server $server): void
    {

    }

    /**
     * Stop module
     *
     * @param Server $server
     */
    public function stop(Server $server): void
    {

    }

    /**
     * Start module
     *
     * @param Server $server
     */
    public function start(Server $server): void
    {

    }
}
