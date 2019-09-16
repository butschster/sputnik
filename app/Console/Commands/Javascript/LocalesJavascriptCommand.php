<?php

namespace App\Console\Commands\Javascript;

use App\Services\LocalesJavascriptGenerator;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LocalesJavascriptCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'locale:javascript';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Javascript locales file';

    /**
     * @param LocalesJavascriptGenerator $generator
     */
    public function handle(LocalesJavascriptGenerator $generator)
    {
        foreach (File::directories(resource_path('lang')) as $directory) {
            $lang = pathinfo($directory, PATHINFO_BASENAME);

            $generator->make(
                $lang
            );

            $this->info(sprintf('Lang file for [%s] locale successfully generated', $lang));
        }
    }
}