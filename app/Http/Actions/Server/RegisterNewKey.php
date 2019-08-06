<?php

namespace App\Http\Actions\Server;

use App\Models\Server;
use App\Rules\Server\Key\PublicKey;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Action;

class RegisterNewKey extends Action
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'server_id' => ['required', Rule::exists('servers', 'id')],
            'key' => ['required', 'string', new PublicKey],
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