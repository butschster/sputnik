<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\User\StoreRequest;
use App\Http\Resources\v1\Server\UserCollection;
use App\Http\Resources\v1\Server\UserResource;
use App\Models\Server;

class UserController extends Controller
{
    /**
     * @param Server $server
     * @return UserCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): UserCollection
    {
        $this->authorize('show', $server);

        $users = $server->users()->paginate();

        return UserCollection::make($users);
    }

    /**
     * @param Server\User $user
     * @return UserResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Server\User $user): UserResource
    {
        $this->authorize('show', $user);

        return UserResource::make($user);
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return UserResource
     */
    public function store(StoreRequest $request, Server $server): UserResource
    {
        $user = $request->persist();

        return UserResource::make($user);
    }

    /**
     * @param Server\User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server\User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return $this->responseDeleted();
    }
}
