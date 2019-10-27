<?php

namespace Module\PHP;

use Domain\Module\Contracts\Entities\Action\Extension;
use Domain\Module\Contracts\Entities\Module;
use App\Models\Server;

class PHPSettings implements Extension
{

    /**
     * {@inheritDoc}
     */
    public function isValid(Module $module, Server $server, array $data = []): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function scriptData(Module $module, Server $server, array $data = []): array
    {
        $modules = $data['modules'];

        return array_merge($module->meta(), [
            'modules_configuration' => $this->prepareModulesConfiguration($module, $modules),
            'server_modules' => $this->prepareModulesListFromGivenData($module, $modules),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function databaseData(Module $module, Server $server, array $data = []): array
    {
        return [
            'modules' => [
                'cli', 'dev', 'sqlite3', 'gd', 'curl', 'mbstring', 'xml', 'zip', 'bcmath', 'intl',
                'fpm', 'mcrypt', 'pdo', 'mysqli',
            ]
        ];
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