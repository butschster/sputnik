<?php

namespace App\Server\Modules;

use App\Contracts\Server\Modules\Registry;
use App\Contracts\Server\Modules\Repository as RepositoryContract;
use App\Events\Server\Module\Installed;
use App\Events\Server\Module\Restarted;
use App\Events\Server\Module\Started;
use App\Events\Server\Module\Stopped;
use App\Events\Server\Module\Uninstalled;
use App\Exceptions\Server\ModuleInstalledException;
use App\Exceptions\Server\ModuleNotInstalledException;
use App\Models\Server;
use Illuminate\Support\Arr;

class Repository implements RepositoryContract
{
    /**
     * @var Registry
     */
    protected $modules;

    /**
     * @param Registry $modules
     */
    public function __construct(Registry $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Install module on specific server
     *
     * @param string $module
     * @param Server $server
     * @param array $data
     *
     * @return Server\Module
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     * @throws \App\Exceptions\Server\ModuleInstalledException
     */
    public function install(string $module, Server $server, array $data = []): Server\Module
    {
        if ($this->isInstalled($module, $server)) {
            throw new ModuleInstalledException(
                sprintf('Module %s has already installed on this server', $module)
            );
        }

        $data = $this->modules->get($module)->configuration()->install($server, $data);

        $model = $server->modules()->create([
            'name' => $module,
            'meta' => $data,
            'status' => Server\Module::STATUS_INSTALLING
        ]);

        return $model;
    }

    /**
     * Uninstall module on specific server
     *
     * @param Server\Module $module
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function uninstall(Server\Module $module): void
    {
        $server = $module->server;

        $module->toModule()->configuration()->uninstall($server);

        $module->delete();

        event(new Uninstalled($server, $module->name));
    }

    /**
     * Restart module on specific server
     *
     * @param Server\Module $module
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function restart(Server\Module $module): void
    {
        $server = $module->server;

        $module->toModule()->configuration()->restart($server);

        event(new Restarted($server, $module->name));
    }

    /**
     * Start module on specific server
     *
     * @param Server\Module $module
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function start(Server\Module $module): void
    {
        $server = $module->server;
        $module->toModule()->configuration()->start($server);

        event(new Started($server, $module->name));
    }

    /**
     * Stop module on specific server
     *
     * @param Server\Module $module
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     */
    public function stop(Server\Module $module): void
    {
        $server = $module->server;
        $module->toModule()->configuration()->stop($server);

        event(new Stopped($server, $module->name));
    }

    /**
     * Check if module installed on specific server
     *
     * @param string $module
     * @param Server $server
     *
     * @return bool
     */
    protected function isInstalled(string $module, Server $server): bool
    {
        return $server->modules()->where('name', $module)->exists();
    }
}
