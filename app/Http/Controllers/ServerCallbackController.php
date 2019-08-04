<?php

namespace App\Http\Controllers;

use App\Events\Server\KeysInstalled;
use App\Models\Server;
use App\Services\Server\ConfiguratorService;
use App\Utils\Ssh\ValueObjects\PublicKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServerCallbackController extends Controller
{
    /**
     * @param ConfiguratorService $service
     * @param Request $request
     * @param Server $server
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(ConfiguratorService $service, Request $request, Server $server)
    {
        $this->validate($request, [
            'event' => ['required', 'string'],
        ]);

        if ($request->event == 'server.key') {
            if (!empty($request->key)) {
                $server->addPublicKey(
                    new PublicKey(Str::random(20), $request->key)
                );
            }
        }

        if ($request->event == 'server.keys_installed') {
            event(new KeysInstalled($server));
        }

        \Log::info('Callback', $request->all());

        return [
            'status' => 'OK',
        ];
    }
}
