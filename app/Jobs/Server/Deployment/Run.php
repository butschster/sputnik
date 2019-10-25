<?php

namespace App\Jobs\Server\Deployment;

use App\Models\Server;
use App\Models\Server\Deployment;
use App\Models\Server\Site;
use App\Models\User;
use App\Services\Server\Site\DeploymentService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Run
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Model
     */
    protected $owner;

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
     * @param Model|null $owner
     * @param User|null $initiator
     */
    public function __construct(Server $server, ?Model $owner = null, ?User $initiator = null)
    {
        $this->server = $server;
        $this->owner = $owner;
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
        $deployment = new Deployment($data);
        $deployment->server()->associate($this->server);

        if ($this->owner) {
            $deployment->owner()->associate($this->owner);
        }
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
        $this->server->alerts()->create([
            'type' => 'server.site.deploy.failed',
            'exception' => (string) $exception,
            'meta' => [
                'owner' => $this->owner
            ]
        ]);
    }
}
