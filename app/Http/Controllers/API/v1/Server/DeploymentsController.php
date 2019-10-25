<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\Server\DeploymentCollection;
use App\Http\Resources\v1\Server\DeploymentResource;
use App\Jobs\Server\Deployment\Run;
use App\Models\Server\Site;
use App\Services\Server\DeploymentService;
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
            new Run($site->server, $site, $request->user())
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
        $this->authorize('deploy', $site);

        return [
            'config' => (string) view('scripts.server.site.deploy', [
                'server' => $site->server,
                'site' => $site,
            ])
        ];
    }
}
