<?php

namespace App\Http\Actions\Server;

use App\Models\Server;
use Domain\SSH\Validation\Rules\PublicKey;
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
            'key' => ['required', 'string', new PublicKey()],
        ];
    }

    public function handle(): void
    {
        $server = Server::findOrFail($this->server_id);

        /** @var Server\User $user */
        $user = $server->users()->where('name', 'root')->firstOrFail();

        $user->addPublicKey(
            Str::random(20), $this->key
        );
    }
}
