<?php

namespace App\Http\Controllers;

use App\Http\Requests\Server\Site\UpdateRepositoryRequest;
use App\Models\Server;
use App\Services\SourceProviders\Factory;

class ServerSitesRepositoryController extends Controller
{
    /**
     * @param UpdateRepositoryRequest $request
     * @param $server
     * @param Server\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRepositoryRequest $request, $server, Server\Site $site)
    {
        $request->persist();

        return back();
    }

    /**
     * @param Factory $factory
     * @param $server
     * @param Server\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerKey(Factory $factory, $server, Server\Site $site)
    {
        $factory->make($site->sourceProvider)->addPublicKey(
            $site->repository,
            $site->server->publicKey()->getContents()
        );

        return back();
    }

    /**
     * @param Factory $factory
     * @param $server
     * @param Server\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerWebhook(Factory $factory, $server, Server\Site $site)
    {
        $factory->make($site->sourceProvider)->addHook(
            $site->repository,
            $site->hooksHandlerUrl()
        );

        return back();
    }
}
