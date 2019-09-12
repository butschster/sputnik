<?php

namespace App\Http\Controllers\API\v1\Server\Site;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\Server\Site\DeploymentCollection;
use App\Http\Resources\v1\Server\Site\DeploymentResource;
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
        $this->authorize('update', $site);

        return DeploymentCollection::make($site->deployments()->paginate());
    }

    /**
     * @param DeploymentService $service
     * @param Request $request
     * @param Site $site
     * @return DeploymentResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deploy(DeploymentService $service, Request $request, Site $site): DeploymentResource
    {
        $this->authorize('deploy', $site);

        $deployment = dispatch_now(
            new Run($site, $request->user())
        );

        return DeploymentResource::make($deployment);
    }


    /**
     * @param Site $site
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function config(Site $site)
    {
        $this->authorize('update', $site);

        return [
            'config' => (string) view('scripts.server.site.deploy', [
                'server' => $site->server,
                'site' => $site,
                'configurator' => server_configurator($site->server)
            ])
        ];
    }
}
