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
     * @param UploadRequest $request
     * @param Site $site
     * @return SiteResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function upload(UploadRequest $request, Site $site): SiteResource
    {
        return SiteResource::make(
            $request->persist()
        );
    }

    /**
     * @param UpdateRequest $request
     * @param Site $site
     * @return SiteResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateRequest $request, Site $site): SiteResource
    {
        return SiteResource::make(
            $request->persist()
        );
    }

    /**
     * @param DeleteRequest $request
     * @param Site $site
     * @return SiteResource
     */
    public function delete(DeleteRequest $request, Site $site): SiteResource
    {
        return SiteResource::make(
            $request->persist()
        );
    }
}
