<?php

namespace Module\NodeJS;

use App\Meta\Fields\Select;
use App\Models\Server;
use Domain\Module\Contracts\Entities\Action\Extension;
use Domain\Module\Contracts\Entities\Action\HasFields;
use Domain\Module\Contracts\Entities\Action\HasSettings;
use Domain\Module\Contracts\Entities\Module;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class NodeJSSettings implements Extension, HasFields, HasSettings
{

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function scriptData(Module $module, Server $server, array $data = []): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function databaseData(Module $module, Server $server, array $data = []): array
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
     * {@inheritDoc}
     */
    public function settings(): array
    {
        return [
            'version' => Arr::last(array_keys($this->availableVersions())),
        ];
    }
}
