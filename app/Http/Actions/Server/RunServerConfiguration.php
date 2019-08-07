<?php

namespace App\Http\Actions\Server;

use App\Events\Server\KeysInstalled;
use App\Models\Server;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Action;

class RunServerConfiguration extends Action
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'server_id' => ['required', Rule::exists('servers', 'id')],
        ];
    }

    public function handle(): void
    {
        $server = Server::findOrFail($this->server_id);

        event(new KeysInstalled($server));

        dispatch(
            new \App\Jobs\Server\ConfigureServer($server)
        );
    }
}
