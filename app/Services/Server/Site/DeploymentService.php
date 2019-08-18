<?php

namespace App\Services\Server\Site;

use App\Jobs\Server\Site\Deployment\TimeOutDeploymentIfStillRunning;
use App\Models\Server\Site\Deployment;
use App\Scripts\Server\Callbacks\RestartPHP;
use App\Scripts\Server\Callbacks\RestartWebServer;
use App\Scripts\Server\Site\Deployment as DeploymentScript;
use App\Services\Server\Runnable;

class DeploymentService
{
    use Runnable;

    /**
     * @param Deployment $deployment
     * @throws \Throwable
     */
    public function deploy(Deployment $deployment)
    {
        $this->setServer($deployment->site->server);
        $this->setOwner($deployment);

        $this->runInBackground(
            new DeploymentScript($deployment),
            [
                'then' => [
                    RestartPHP::class,
                    RestartWebServer::class,
                ],
            ]
        );

        dispatch(new TimeOutDeploymentIfStillRunning($deployment))
            ->delay(now()->addMinutes(30));
    }
}
