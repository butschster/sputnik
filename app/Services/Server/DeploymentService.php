<?php

namespace App\Services\Server;

use App\Jobs\Server\Deployment\TimeOutDeploymentIfStillRunning;
use App\Models\Server\Deployment;
use App\Scripts\Server\Callbacks\RestartWebServer;
use App\Scripts\Server\Deployment as DeploymentScript;

class DeploymentService
{
    use Runnable;

    /**
     * @param Deployment $deployment
     * @throws \Throwable
     */
    public function deploy(Deployment $deployment)
    {
        $this->setServer($deployment->server);
        $this->setOwner($deployment);

        $this->runInBackground(
            new DeploymentScript($deployment),
            [
                'then' => [
                    RestartWebServer::class,
                ],
            ]
        );

        dispatch(new TimeOutDeploymentIfStillRunning($deployment))
            ->delay(now()->addMinutes(30));
    }
}
