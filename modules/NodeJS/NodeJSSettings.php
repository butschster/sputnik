<?php

namespace Module\NodeJS;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Action\Extension;
use App\Contracts\Server\Modules\Action\HasFields;
use App\Contracts\Server\Modules\Action\HasSettings;
use App\Meta\Fields\Select;
use App\Models\Server;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class NodeJSSettings implements Extension, HasFields, HasSettings
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
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return array
     */
    public function data(Module $module, Server $server, array $data = []): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            (new Select('version', 'NodeJs version', $this->availableVersions()))
                ->addValidationRule('nullable')
                ->addValidationRule((string)Rule::in(array_keys($this->availableVersions()))),
        ];
    }

    /**
     * @return array
     */
    public function settings(): array
    {
        return [
            'version' => Arr::last(array_keys($this->availableVersions())),
        ];
    }
}
