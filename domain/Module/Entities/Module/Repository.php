<?php

namespace Domain\Module\Entities\Module;

use Domain\Module\Contracts\Entities\Module\Repository as RepositoryContract;
use App\Models\Server;
use Domain\Module\Contracts\Registry;
use Domain\Module\Exceptions\ModuleInstalledException;
use Domain\Module\Exceptions\ModuleNotFoundException;

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
     * @return Server\Action
     * @throws ModuleNotFoundException
     * @throws ModuleInstalledException
     */
    public function runAction(string $module, string $action, Server $server, array $data = []): Server\Action
    {
        $module = $this->modules->get($module);

        if (!$module->getAction($action)->isValid($server, $data)) {
            throw new ModuleInstalledException(
                sprintf('Module %s has already installed on this server', $module)
            );
        }

        return $module->runAction($action, $server, $data);
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
