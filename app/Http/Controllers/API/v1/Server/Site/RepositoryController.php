<?php

namespace App\Http\Controllers\API\v1\Server\Site;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\Site\Repository\UpdateRequest;
use App\Http\Resources\v1\Server\SiteResource;
use App\Models\Server\Site;
use App\Services\SourceProviders\Factory as SourceProvidersFactory;

class RepositoryController extends Controller
{
    /**
     * @param UpdateRequest $request
     * @param Site $site
     * @return SiteResource
     */
    public function update(UpdateRequest $request, Site $site): SiteResource
    {
        return SiteResource::make(
            $request->persist()
        );
    }

    /**
     * @param SourceProvidersFactory $factory
     * @param Site $site
     * @return array
     */
    public function syncRemote(SourceProvidersFactory $factory, Site $site)
    {
        $provider = $factory->make($site->sourceProvider);

        $provider->addPublicKey(
            $site->repository,
            $site->server->publicKey()->getContents()
        );

        $provider->addHook(
            $site->repository,
            $site->hooksHandlerUrl()
        );

        return ['status' => 'ok'];
    }
}
