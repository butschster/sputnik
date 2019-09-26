<?php

namespace App\Server\Modules;

use App\Meta\Fields\Select;
use App\Models\Server;
use App\Server\Module;
use Illuminate\Validation\Rule;

class BaseSettings extends Module
{
    /**
     * Get module categories
     *
     * @return array
     */
    public function categories(): array
    {
        return ['base'];
    }

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'Base settings';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'base_settings';
    }

    /**
     * @return array
     */
    public function defaultSettings(): array
    {
        return [
            'timezone' => 'UTC'
        ];
    }

    /**
     * Get module configuration
     * @return \App\Contracts\Server\Modules\Configuration
     */
    public function configuration(): \App\Contracts\Server\Modules\Configuration
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
                $data = $this->prepareData($server, $data);

                $script = $this->render($server, 'base.install', $data);

                $this->installModule(
                    $server,
                    $script,
                    sprintf('Install %s', $this->module->title())
                );

                return $data;
            }

            /**
             * Uninstall module
             *
             * @param Server $server
             */
            public function uninstall(Server $server): void
            {

            }
        };
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        $zones = \DateTimeZone::listIdentifiers();

        return [
            (new Select('timezone', 'Server Timezone', $zones))
                ->addValidationRule('required')
                ->addValidationRule((string) Rule::in($zones)),
        ];
    }
}
