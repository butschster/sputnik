<?php

namespace Module\OpenVPN\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Models\Server;
use Module\OpenVPN\Http\Requests\Client\StoreRequest;
use Module\OpenVPN\Http\Resources\v1\ClientResource;
use Module\OpenVPN\Http\Resources\v1\ClientsCollection;
use Module\OpenVPN\Models\Client;
use Module\OpenVPN\OpenVPNClientService;

class ClientsController extends Controller
{
    /**
     * @param Server $server
     * @return ClientsCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): ClientsCollection
    {
        $this->authorize('show', $server);

        return ClientsCollection::make(
            Client::forServer($server)->get()
        );
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return ClientResource
     */
    public function store(StoreRequest $request, Server $server): ClientResource
    {
        return ClientResource::make(
            $request->persist()
        );
    }

    /**
     * @param OpenVPNClientService $service
     * @param Client $client
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function download(OpenVPNClientService $service, Client $client)
    {
        $this->authorize('show', $client);

        return response()->streamDownload(function () use ($service, $client) {
            echo $service->getClientConfig($client);
        }, $client->name . '.ovpn');
    }

    /**
     * @param Client $client
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Client $client)
    {
        $this->authorize('delete', $client);

        $client->delete();

        return $this->responseDeleted();
    }
}