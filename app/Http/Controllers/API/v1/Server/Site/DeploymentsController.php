<?php

namespace App\Http\Controllers\API\v1\Server\Site;

use App\Http\Controllers\API\Controller;
use App\Jobs\Server\Site\Deploy;
use App\Models\Server\Site;
use App\Services\Server\Site\DeploymentService;
use Illuminate\Http\Request;

class DeploymentsController extends Controller
{
    /**
     * @param DeploymentService $service
     * @param Request $request
     * @param Site $site
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deploy(DeploymentService $service, Request $request, Site $site)
    {
        $this->authorize('deploy', $site);

        dispatch(
            new Deploy($site, $request->user())
        );

        return ['status' => 'ok'];
    }


    /**
     * @param Site $site
     * @return array
     */
    public function config(Site $site)
    {
        return [
            'config' => view('scripts.server.site.deploy', [
                'server' => $site->server,
                'site' => $site,
                'configurator' => server_configurator($site->server)
            ])
        ];
    }
}
