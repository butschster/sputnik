<?php

namespace App\Console\Commands\Modules;

use App\Modules\Manifest;
use Illuminate\Console\Command;

class ModulesDiscoverCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'modules:discover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild the cached modules manifest';

    /**
     * @param Manifest $manifest
     */
    public function handle(Manifest $manifest)
    {
        $manifest->build();

        foreach (array_keys($manifest->manifest) as $package) {
            $this->line("<info>Discovered Package:</info> {$package}");
        }

        $this->info('Modules manifest generated successfully.');
    }
}