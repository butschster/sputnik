<?php

namespace App\Scripts\Server\Site;

use App\Models\Server\Site\Deployment as DeploymentModel;
use App\Utils\SSH\Script;

class Deployment extends Script
{
    protected $name = 'Site deployment';
    /**
     * @var DeploymentModel
     */
    protected $deployment;

    /**
     * @param DeploymentModel $deployment
     */
    public function __construct(DeploymentModel $deployment)
    {
        $this->deployment = $deployment;
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string
    {
        return view('scripts.server.site.deploy', [
            'server' => $this->deployment->site->server,
            'site' => $this->deployment->site,
        ]);
    }
}
