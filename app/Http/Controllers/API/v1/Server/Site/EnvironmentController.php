<?php

namespace App\Http\Controllers\API\v1\Server\Site;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\Site\Environment\DeleteRequest;
use App\Http\Requests\Server\Site\Environment\UpdateRequest;
use App\Http\Requests\Server\Site\Environment\UploadRequest;
use App\Http\Resources\v1\Server\SiteResource;
use App\Models\Server\Site;

class EnvironmentController extends Controller
{
    /**
     * @param Site $site
     * @return SiteResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Site $site): EnvironmentResource
    {
        $this->authorize('deploy', $site);

        return EnvironmentResource::make(
            $site->environment
        );
    }

    /**
     * @param UploadRequest $request
     * @param Site $site
     * @return EnvironmentResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function upload(UploadRequest $request, Site $site): EnvironmentResource
    {
        return EnvironmentResource::make(
            $request->persist()->environment
        );
    }

    /**
     * @param UpdateRequest $request
     * @param Site $site
     * @return EnvironmentResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateRequest $request, Site $site): EnvironmentResource
    {
        return EnvironmentResource::make(
            $request->persist()->environment
        );
    }

    /**
     * @param DeleteRequest $request
     * @param Site $site
     * @return EnvironmentResource
     */
    public function delete(DeleteRequest $request, Site $site): EnvironmentResource
    {
        return EnvironmentResource::make(
            $request->persist()->environment
        );
    }
}
