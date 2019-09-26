<?php

namespace App\Server\Modules\Javascript;

use App\Contracts\Server\Modules\Configuration;
use App\Meta\Fields\Select;
use App\Models\Server;
use App\Server\Module;
use Illuminate\Support\Arr;
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
        return [
            '8.x' => 'v.8',
            '10.x' => 'v.10',
            '11.x' => 'v.11',
            '12.x' => 'v.12',
        ];
    }

    /**
     * @return array
     */
    public function defaultSettings(): array
    {
        return [
            'version' => Arr::last(array_keys($this->availableVersions())),
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
             *
             * @return array
             * @throws \Throwable
             */
            public function install(Server $server, array $data): array
            {
                $data = $this->prepareData($server, $data);

                $script = $this->render($server, 'javascript.nodejs.install', $data);

                $this->installModule($server, $script, sprintf('Install %s', $this->module->title()));

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
     * @return array
     */
    protected function fields(): array
    {
        return [
            (new Select('version', 'NodeJs version', $this->availableVersions()))
                ->addValidationRule('nullable')
                ->addValidationRule((string) Rule::in(array_keys($this->availableVersions()))),
        ];
    }
}
