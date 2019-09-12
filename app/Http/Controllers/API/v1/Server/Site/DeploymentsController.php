<?php

namespace App\Http\Controllers\API\v1\Server\Site;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\Server\Site\DeploymentCollection;
use App\Jobs\Server\Site\Deployment\Run;
use App\Models\Server\Site;
use App\Services\Server\Site\DeploymentService;
use Illuminate\Http\Request;

class DeploymentsController extends Controller
{
    /**
     * @param Request $request
     * @param Site $site
     * @return DeploymentCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, Site $site): DeploymentCollection
    {
        $this->authorize('deploy', $site);

        return DeploymentCollection::make($site->deployments);
    }

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
            new Run($site, $request->user())
        );

        return $this->responseOk();
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
