<?php

namespace App\Server\Modules\Actions\Extensions;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Action\Extension;
use App\Contracts\Server\Modules\Action\HasFields;
use App\Contracts\Server\Modules\Action\HasSettings;
use App\Meta\Fields\Select;
use App\Models\Server;
use Illuminate\Validation\Rule;

class BaseSettings implements Extension, HasFields, HasSettings
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
        return [];
    }

    /**
     * @return array
     */
    public function fields(): array
    {
        $zones = \DateTimeZone::listIdentifiers();

        return [
            (new Select('timezone', 'Server Timezone', $zones))
                ->addValidationRule('required')
                ->addValidationRule((string) Rule::in($zones)),
        ];
    }

    /**
     * @return array
     */
    public function settings(): array
    {
        return [
            'timezone' => 'UTC',
        ];
    }
}
