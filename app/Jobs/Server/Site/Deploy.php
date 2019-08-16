<?php

namespace App\Jobs\Server\Site;

use App\Models\Server\Site;
use App\Models\User;
use App\Services\Server\Site\DeploymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Deploy
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
     */
    public function handle(DeploymentService $service): void
    {
        if (!\Gate::allows('deploy', $this->site)) {
            return;
        }

        $data = [
            'branch' => $this->site->repositoryBranch(),
            'initiator_id' => $this->initiator ? $this->initiator->id : null,
            'commit_hash' => '',
        ];

        $service->deploy(
            $this->site->deployments()->create($data)
        );
    }
}
