<?php

namespace App\Services\Server\Site;

use App\Models\Server\Site\Deployment;
use App\Scripts\Server\Site\Deployment as DeploymentScript;
use App\Services\Server\Runnable;

class DeploymentService
{
    use Runnable;

    /**
     * @param Deployment $deployment
     */
    public function deploy(Deployment $deployment)
    {
        $this->setServer($deployment->site->server);
        $this->setOwner($deployment);

        $this->runJob(
            new DeploymentScript($deployment)
        );
    }
}
