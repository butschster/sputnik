<?php

namespace App\Http\Controllers;

use App\Http\Requests\Server\Site\StoreRequest;
use App\Http\Requests\Server\Site\UpdateRepositoryRequest;
use App\Models\Server;
use App\Services\Server\Site\DeploymentService;
use Illuminate\Http\Request;

class ServerSitesController extends Controller
{
    /**
     * @param Server\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($server, Server\Site $site)
    {
        return view('server.site.show', compact('site'));
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreRequest $request, Server $server)
    {
        $site = $request->persist();

        return redirect(route('server.site.show', [$server, $site]));
    }

    /**
     * @param DeploymentService $service
     * @param Request $request
     * @param $server
     * @param Server\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deploy(DeploymentService $service, Request $request, $server, Server\Site $site)
    {
        $service->deploy(
            $site->deployments()->create([
                'initiator_id' => $request->user()->id,
                'branch' => $site->repositoryBranch(),
                'commit_hash' => 'abc'
            ])
        );

        return back();
    }

    /**
     * @param $server
     * @param Server\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deployConfig($server, Server\Site $site)
    {
        return view('server.site.deploy_config', [
            'script' => view('scripts.server.site.deploy', [
                'server' => $site->server,
                'site' => $site,
            ])
        ]);
    }

    /**
     * @param UpdateRepositoryRequest $request
     * @param $server
     * @param Server\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRepository(UpdateRepositoryRequest $request, $server, Server\Site $site)
    {
        $request->persist();

        return back();
    }

    /**
     * @param Server\Site $site
     * @return \Illuminate\Foundation\Testing\TestResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function delete(Server\Site $site)
    {
        $site->delete();

        return redirect(route('server.show', $site->server));
    }
}
