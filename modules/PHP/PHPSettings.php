<?php

namespace Module\PHP;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Action\Extension;
use App\Models\Server;

class PHPSettings implements Extension
{

    /**
     * Check if action can be run
     *
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return bool
     */
    public function isValid(Module $module, Server $server, array $data = []): bool
    {
        return true;
    }

    /**
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return array
     */
    public function data(Module $module, Server $server, array $data = []): array
    {
        $modules = [
            'cli', 'dev', 'sqlite3', 'gd', 'curl', 'mbstring', 'xml', 'zip', 'bcmath', 'intl',
            'fpm', 'mcrypt', 'pdo', 'mysqli',
        ];

        return array_merge($module->meta(), [
            'modules_configuration' => $this->prepareModulesConfiguration($module, $modules),
            'server_modules' => $this->prepareModulesListFromGivenData($module, $modules),
        ]);
    }

    /**
     * @param Module $module
     * @param array $modules
     * @return array
     */
    public function prepareModulesListFromGivenData(Module $module, array $modules): array
    {
        return collect($modules)->map(function ($phpModule) use ($module) {
            return $module->key() . '-' . $phpModule;
        })->all();
    }

    /**
     * @param Module $module
     * @param array $modules
     * @return array
     */
    public function prepareModulesConfiguration(Module $module, array $modules): array
    {
        return collect($modules)->map(function ($phpModule) use ($module) {
            if (!view()->exists('PHP::scripts.php.configuration.' . $phpModule)) {
                return null;
            }

            return view('PHP::scripts.php.configuration.' . $phpModule, $module->meta())->render();
        })->all();
    }
}