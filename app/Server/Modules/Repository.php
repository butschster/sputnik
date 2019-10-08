<?php

namespace App\Server\Modules;

use App\Contracts\Server\Modules\Registry;
use App\Contracts\Server\Modules\Repository as RepositoryContract;
use App\Exceptions\Server\ModuleInstalledException;
use App\Models\Server;

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
     * @param string $action
     * @param Server $server
     * @param array $data
     *
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     * @throws \App\Exceptions\Server\ModuleInstalledException
     */
    public function runAction(string $module, string $action, Server $server, array $data = [])
    {
        $module = $this->modules->get($module);

        if (!$module->getAction($action)->isValid($server, $data)) {
            throw new ModuleInstalledException(
                sprintf('Module %s has already installed on this server', $module)
            );
        }

        $module->runAction($action, $server, $data);
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
