<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\Site\StoreRequest;
use App\Http\Resources\v1\Server\SiteCollection;
use App\Http\Resources\v1\Server\SiteResource;
use App\Http\Resources\v1\ServerCollection;
use App\Models\Server;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * @param Server $server
     * @return SiteCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): SiteCollection
    {
        $this->authorize('show', $server);

        return SiteCollection::make(
            $server->sites()->get()
        );
    }

    /**
     * @param Request $request
     * @return ServerCollection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function search(Request $request): ServerCollection
    {
        $this->validate($request, [
            'query' => 'required|string'
        ]);

        $servers = Server\Site::search($request->input('query'))
            ->with([
                'filters' => 'user_id:'.$request->user()->id,
            ])->get();

        return ServerCollection::make($servers);
    }

    /**
     * @param Server\Site $site
     * @return SiteResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Server\Site $site)
    {
        $this->authorize('show', $site);

        $site->load('server');

        return SiteResource::make($site);
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return SiteResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRequest $request, Server $server)
    {
        return SiteResource::make(
            $request->persist()
        );
    }

    /**
     * @param Server\Site $site
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server\Site $site)
    {
        $this->authorize('delete', $site);

        $site->delete();

        return $this->responseDeleted();
    }
}
