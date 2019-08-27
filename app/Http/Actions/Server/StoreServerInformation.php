<?php

namespace App\Http\Actions\Server;

use App\Models\Server;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Action;

class StoreServerInformation extends Action
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'server_id' => ['required', Rule::exists('servers', 'id')->whereNull('os_information')],
            'os' => 'required|string',
            'version' => 'required|string',
            'architecture' => 'required|string',
        ];
    }

    public function handle(): void
    {
        $server = Server::findOrFail($this->server_id);

        $server->update([
            'os_information' => $this->only('os', 'version', 'architecture')
        ]);

        event();

        if (!$server->refresh()->systemInformation()->isSupported()) {
            $server->markAsFailed();
        }
    }
}
