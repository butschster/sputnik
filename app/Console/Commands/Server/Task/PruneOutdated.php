<?php

namespace App\Console\Commands\Server\Task;

use App\Models\Server\Task;
use Illuminate\Console\Command;

class PruneOutdated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:task:prune-outdated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune outdated tasks';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Task::prune(
            now()->subWeeks(2)
        );
    }
}
