<?php

namespace App\Http\Actions\Server;

use App\Models\Server;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Action;

class RegisterNewKey extends Action
{
    /**
     * TODO Add public key validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            'server_id' => ['required', Rule::exists('servers', 'id')],
            'key' => 'required|string',
        ];
    }

    public function handle()
    {
        $server = Server::findOrFail($this->server_id);

        $server->addPublicKey(Server\Key::create([
            'name' => Str::random(20),
            'content' => $this->key,
        ]));
    }
}
