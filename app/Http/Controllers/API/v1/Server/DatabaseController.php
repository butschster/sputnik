<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\Database\StoreRequest;
use App\Http\Resources\v1\Server\DatabaseCollection;
use App\Http\Resources\v1\Server\DatabaseResource;
use App\Models\Server;

class DatabaseController extends Controller
{
    /**
     * @param Server $server
     * @return DatabaseCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): DatabaseCollection
    {
        $this->authorize('show', $server);

        $databases = $server->databases()->paginate();

        return DatabaseCollection::class($databases);
    }

    /**
     * @param Server\Database $database
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Server\Database $database): DatabaseResource
    {
        $this->authorize('show', $database);

        return DatabaseResource::make($database);
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return DatabaseResource
     */
    public function store(StoreRequest $request, Server $server): DatabaseResource
    {
        $database = $request->persist();

        return DatabaseResource::make($database);
    }

    /**
     * @param Server\Database $database
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server\Database $database)
    {
        $this->authorize('delete', $database);

        $database->delete();

        return $this->responseDeleted();
    }
}
