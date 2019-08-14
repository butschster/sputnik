<?php

namespace App\Scripts\Server\Site;

use App\Models\Server\Site\Deployment as DeploymentModel;
use App\Utils\SSH\Script;

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
        return "Site {$this->deployment->site->domain} deployment";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string
    {
        $server = $this->deployment->site->server;

        $configurator = server_configurator($server);

        return view('scripts.server.site.deploy', [
            'server' => $server,
            'site' => $this->deployment->site,
            'configurator' => $configurator
        ]);
    }
}
