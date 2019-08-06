<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\Key\StoreRequest;
use App\Http\Resources\v1\Server\KeyResource;
use App\Models\Server;

class ServerKeysController extends Controller
{
    /**
     * Store public key for the server
     *
     * @param StoreRequest $request
     * @param Server $server
     * @return KeyResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRequest $request, Server $server)
    {
        $this->authorize('store', [Server\Key::class, $server]);

        $key = $request->persist();

        return KeyResource::make($key);
    }

    /**
     * Remove public key from the server
     *
     * @param Server\Key $key
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server\Key $key)
    {
        $this->authorize('delete', $key);
    }
}
