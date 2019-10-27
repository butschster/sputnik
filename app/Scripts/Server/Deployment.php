<?php

namespace App\Scripts\Server;

use App\Models\Server\Deployment as DeploymentModel;
use Domain\SSH\Script;

class Deployment extends Script
{
    /**
     * @var DeploymentModel
     */
    protected $deployment;

    /**
     * The user that the script should be run as.
     *
     * @var string
     */
    //protected $sshAs = self::USER_SPUTNIK;

    /**
     * @param DeploymentModel $deployment
     */
    public function __construct(DeploymentModel $deployment)
    {
        $this->deployment = $deployment;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "Site deploy";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string
    {
        $server = $this->deployment->server;

        return view('scripts.server.site.deploy', [
            'server' => $server,
            'site' => $this->deployment->site,
            'configurator' => $server->toConfigurator()
        ]);
    }
}
