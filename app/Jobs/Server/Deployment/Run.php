<?php

namespace App\Jobs\Server\Deployment;

use App\Models\Server;
use App\Models\Server\Deployment;
use App\Models\User;
use App\Services\Server\DeploymentService;
use Domain\Alert\Builder;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Run
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Server\Site
     */
    protected $site;

    /**
     * @var User|null
     */
    protected $initiator;

    /**
     * @var Server
     */
    protected $server;

    /**
     * @param Server $server
     * @param Server\Site $site
     * @param User|null $initiator
     */
    public function __construct(Server $server, Server\Site $site, ?User $initiator = null)
    {
        $this->server = $server;
        $this->site = $site;
        $this->initiator = $initiator;
    }

    /**
     * @param DeploymentService $service
     * @return Deployment
     * @throws \Throwable
     */
    public function handle(DeploymentService $service): Deployment
    {
        $data = [
            'branch' => $this->site->repositoryBranch(),
            'repository' => $this->site->cloneUrl(),
            'path' => $this->site->path(),
            'environment' => $this->site->environment ?? [],
            'initiator_id' => $this->initiator ? $this->initiator->id : null,
            'commit_hash' => ''
        ];

        $deployment = new Deployment($data);
        $deployment->server()->associate($this->server);

        $deployment->owner()->associate($this->site);
        $deployment->save();

        $service->deploy($deployment);

        return $deployment;
    }

    /**
     * Handle a job failure.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Builder::for($this->server, $exception)
            ->setType('server.site.deploy.failed')
            ->setMeta([
                'owner' => $this->site
            ])
            ->store();
    }
}
