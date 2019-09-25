<?php

namespace App\Server\Modules\Javascript;

use App\Contracts\Server\Modules\Configuration;
use App\Models\Server;
use App\Server\Module;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NodeJs extends Module
{
    /**
     * Get module categories
     *
     * @return array
     */
    public function categories(): array
    {
        return ['javascript', 'webserver'];
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'Node.js';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'nodejs';
    }

    /**
     * @return array
     */
    public function availableVersions(): array
    {
        return [8, 10, 11, 12];
    }

    /**
     * Get validation rules for module
     *
     * @param Request $request
     *
     * @return array
     */
    public function validationRules(Request $request): array
    {
        return [
            'version' => ['required', 'string', Rule::in($this->availableVersions())],
        ];
    }

    /**
     * Get module configuration
     * @return Configuration
     */
    public function configuration(): Configuration
    {
        return new class($this) extends \App\Server\Modules\Configuration
        {

            /**
             * Install module
             *
             * @param Server $server
             * @param array $data
             * @return array
             */
            public function install(Server $server, array $data): array
            {
                $script = $this->render($server, 'javascript.nodejs.install', $data);

                $this->runScript($server, $script, sprintf('Install %s', $this->module->title()));

                return $data;
            }

            /**
             * Uninstall module
             *
             * @param Server $server
             */
            public function uninstall(Server $server): void
            {
                $script = $this->render($server, 'javascript.nodejs.uninstall');

                $this->runScript($server, $script, sprintf('Uninstall %s', $this->module->title()));
            }
        };
    }

    /**
     * Get module dictionaries
     * @return array
     */
    public function dictionaries(): array
    {
        return [
            'versions' => $this->availableVersions()
        ];
    }
}
