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
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function settings(): array
    {
        return [
            'timezone' => 'UTC',
        ];
    }
}
