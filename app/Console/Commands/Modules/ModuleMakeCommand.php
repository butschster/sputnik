<?php

namespace App\Console\Commands\Modules;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;

class ModuleMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Make a new module';

    /**
     * The filesystem instance.
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The views that need to be exported.
     * @var array
     */
    protected $stubs = [
        'Providers/ServiceProvider.stub' => 'Providers/ServiceProvider.php',
        'resources/assets/js/init.stub' => 'resources/js/bootstrap.js',
        'routes/api.stub' => 'routes/api_v1.php',
        'composer.stub' => 'composer.json',
    ];

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        foreach ($this->stubs as $stubPath => $filePath) {
            $stub = $this->files->get(__DIR__ . '/stubs/module/' . $stubPath);
            $this->makeDirectory($path = $this->makeModuleFilePath($filePath));
            $this->files->put($path, $this->buildFile($stub));
        }

        $this->info(sprintf(
            'Module [modules/%s] generated',
            $this->getNameInput()
        ));
    }

    /**
     * @param string $content
     *
     * @return string
     */
    protected function buildFile(string $content)
    {
        return  $this->replaceSystemNames(
            $content
        );
    }

    /**
     * @param $path
     *
     * @return string
     */
    protected function makeModuleFilePath($path)
    {
        $path = $this->replaceSystemNames($path);

        return base_path('modules/' . $this->getNameInput() . '/' . $path);
    }

    protected function replaceSystemNames(string $data)
    {
        $data = str_replace(
            [
                '{{module-camel-case}}',
                '{{module}}',
                '{{namespace}}',
                '{{module-title}}',
                '{{namespace-escaped}}'
            ],
            [
                $this->moduleCameCase(),
                $this->getNameInput(),
                $this->moduleNamespace(),
                Str::title(preg_replace('/[^a-zA-Z0-9]+/', ' ', $this->getNameInput())),
                $this->escapedModuleNamespace(),
            ],
            $data
        );

        return $data;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string $path
     *
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string $name
     *
     * @return string
     */
    protected function qualifyClass($name)
    {
        return $name;
    }

    /**
     * Get the desired class name from the input.
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }

    /**
     * Get the root namespace for the class.
     * @return string
     */
    protected function moduleNamespace()
    {
        return 'Module\\' . $this->moduleCameCase();
    }

    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param  string $name
     *
     * @return string
     */
    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the module'],
        ];
    }

    /**
     * @return string
     */
    protected function moduleCameCase(): string
    {
        return Str::studly($this->getNameInput());
    }

    /**
     * @return mixed
     */
    protected function escapedModuleNamespace(): string
    {
        return str_replace('\\', '\\\\', $this->moduleNamespace());
    }
}
