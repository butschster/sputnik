<?php

namespace App\Console\Commands\Server;

use App\Models\Server\Deployment;
use Illuminate\Console\Command;

class MarkAsTimeoutExpiredDeployments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:deployments:timeout-expired';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Deployment::where('created_at', '<', now()->subHour())
            ->whereIn('status', [Deployment::STATUS_PENDING, Deployment::STATUS_RUNNING])
            ->update([
                'status' => Deployment::STATUS_TIMEOUT,
            ]);
    }
}
