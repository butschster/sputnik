<?php

namespace App\Http\Actions\Server;

use App\Models\Server;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Action;

class ProcessServerEvents extends Action
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'server_id' => ['required', Rule::exists('servers', 'id')],
            'message' => 'required|string',
        ];
    }

    public function handle(): void
    {
        $server = Server::findOrFail($this->server_id);

        $server->events()->create([
            'message' => $this->message,
        ]);
    }
}
