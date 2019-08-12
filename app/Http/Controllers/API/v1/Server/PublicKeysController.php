<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\PublicKey\StoreRequest;
use App\Http\Resources\v1\Server\PublicKeyResource;
use App\Models\Server;

class PublicKeysController extends Controller
{
    /**
     * Store public key for the server
     *
     * @param StoreRequest $request
     * @param Server $server
     * @return PublicKeyResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRequest $request, Server $server)
    {
        $this->authorize('store', [Server\PublicKey::class, $server]);

        $key = $request->persist();

        return PublicKeyResource::make($key);
    }

    /**
     * Remove public key from the server
     *
     * @param Server\PublicKey $key
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server\PublicKey $key)
    {
        $this->authorize('delete', $key);

        $key->delete();

        return $this->responseDeleted();
    }
}
