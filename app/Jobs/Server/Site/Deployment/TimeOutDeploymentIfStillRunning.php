<?php

namespace App\Jobs\Server\Site\Deployment;

use App\Models\Server\Site\Deployment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TimeOutDeploymentIfStillRunning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Deployment
     */
    protected $deployment;

    /**
     * @param Deployment $deployment
     */
    public function __construct(Deployment $deployment)
    {
        $this->deployment = $deployment;
    }

    public function handle(): void
    {
        if (! $this->deployment->hasEnded()) {
            $this->deployment->markAsTimedOut();
        }
    }
}
