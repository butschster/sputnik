<?php

namespace App\Jobs\Server\Site\Deployment;

use App\Models\Server\Site;
use App\Models\User;
use App\Services\Server\Site\DeploymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Run
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Site
     */
    protected $site;

    /**
     * @var User|null
     */
    protected $initiator;

    /**
     * @param Site $site
     * @param User|null $initiator
     */
    public function __construct(Site $site, ?User $initiator = null)
    {
        $this->site = $site;
        $this->initiator = $initiator;
    }

    /**
     * @param DeploymentService $service
     * @return Site\Deployment
     * @throws \Throwable
     */
    public function handle(DeploymentService $service): Site\Deployment
    {
        $data = [
            'branch' => $this->site->repositoryBranch(),
            'initiator_id' => $this->initiator ? $this->initiator->id : null,
            'commit_hash' => ''
        ];

        $service->deploy(
            $deployment = $this->site->deployments()->create($data)
        );

        return $deployment;
    }
}
