<?php

namespace App\Console\Commands\Javascript;

use App\Services\LocalesJavascriptGenerator;
use Illuminate\Console\Command;

class LocalesJavascriptCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'locale:javascript {lang}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Javascript locales file';

    /**
     * @param LocalesJavascriptGenerator $generator
     * @return int
     */
    public function handle(LocalesJavascriptGenerator $generator)
    {
        if ($generator->make($this->argument('lang'))) {
            $this->info("Locales file created");

            return 0;
        }

        $this->error("Could not create locales file");

        return 1;
    }
}