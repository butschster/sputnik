<?php

namespace Module\OpenVPN\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Models\Server;
use Domain\Record\Repositories\RecordRepository;
use Module\OpenVPN\Http\Requests\Client\StoreRequest;
use Module\OpenVPN\Http\Resources\v1\ClientResource;
use Module\OpenVPN\Http\Resources\v1\ClientsCollection;
use Module\OpenVPN\OpenVPNClientService;

class ClientsController extends Controller
{
    /**
     * @var RecordRepository
     */
    protected $repository;

    /**
     * @var OpenVPNClientService
     */
    protected $service;

    /**
     * @param RecordRepository $repository
     * @param OpenVPNClientService $service
     */
    public function __construct(RecordRepository $repository, OpenVPNClientService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @param Server $server
     * @return ClientsCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Server $server): ClientsCollection
    {
        $this->authorize('show', $server);

        return ClientsCollection::make(
            $this->repository->list($server, 'openvpn', 'client')
        );
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return ClientResource
     */
    public function store(StoreRequest $request, Server $server): ClientResource
    {
        $record = $request->persist();

        $this->service->create($record);
        return ClientResource::make(
            $record
        );
    }

    /**
     * @param string $client
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function download(string $client)
    {
        $record = $this->repository->find($client);
        $this->authorize('show', $record);

        return response()->streamDownload(function () use ($record) {
            echo $this->service->getConfig($record);
        }, $record->meta['name'] . '.ovpn');
    }

    /**
     * @param string $client
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(string $client)
    {
        $this->authorize(
            'delete', $record = $this->repository->find($client)
        );

        if ($this->repository->delete($client)) {
            $this->service->delete($record);
        }

        return $this->responseDeleted();
    }
}