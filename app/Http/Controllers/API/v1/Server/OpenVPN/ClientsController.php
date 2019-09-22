<?php

namespace App\Http\Controllers\API\v1\Server\OpenVPN;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\OpenVPN\StoreRequest;
use App\Http\Resources\v1\Server\OpenVPN\ClientResource;
use App\Http\Resources\v1\Server\OpenVPN\ClientsCollection;
use App\Models\OpenVPNServer;
use App\Models\Server;
use App\Services\Server\OpenVPNService;

class ClientsController extends Controller
{
    /**
     * @param OpenVPNServer $server
     * @return ClientsCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(OpenVPNServer $openvpn): ClientsCollection
    {
        $this->authorize('show', $openvpn);

        $users = $openvpn->clients()->get();

        return ClientsCollection::make($users);
    }

    /**
     * @param StoreRequest $request
     * @param OpenVPNServer $openvpn
     * @return ClientResource
     */
    public function store(StoreRequest $request, OpenVPNServer $openvpn): ClientResource
    {
        return ClientResource::make(
            $request->persist()
        );
    }

    /**
     * @param OpenVPNService $service
     * @param Server\OpenVPN\Client $client
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function download(OpenVPNService $service, Server\OpenVPN\Client $client)
    {
        $this->authorize('show', $client);

        return response()->streamDownload(function () use ($service, $client) {
            echo $service->getClientConfig($client);
        }, $client->name . '.ovpn');
    }

    /**
     * @param Server\OpenVPN\Client $client
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server\OpenVPN\Client $client)
    {
        $this->authorize('delete', $client);

        $client->delete();

        return $this->responseDeleted();
    }
}