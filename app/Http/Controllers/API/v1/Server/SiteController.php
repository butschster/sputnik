<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\Site\SearchRequest;
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
     * @param SearchRequest $request
     * @return SiteCollection
     */
    public function search(SearchRequest $request): SiteCollection
    {
        return SiteCollection::make(
            $request->search()
        );
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
