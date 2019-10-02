<?php

namespace App\Modules;

use App\Contracts\Modules\ModuleInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

abstract class Module extends ServiceProvider implements ModuleInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $controllerNamespace;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @param Application $application
     * @param string $name
     * @param string|null $namespace
     */
    public function __construct(Application $application, string $name, string $namespace = null)
    {
        parent::__construct($application);

        $this->name = $name;
        $this->namespace = ($namespace ?: Str::studly($name));
        $this->controllerNamespace = ($namespace ?: Str::studly($name)) . '\Http\Controllers';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|null $path
     *
     * @return string
     */
    public function getPath(string $path = ''): string
    {
        return modules_path($this->getName() . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getControllerNamespace(): string
    {
        return $this->controllerNamespace;
    }

    public function register()
    {

    }

    public function boot()
    {
        $this->loadTranslationsFrom(
            modules_path("{$this->name}/resources/lang"),
            $this->name
        );

        $this->loadViewsFrom(
            modules_path("{$this->name}/resources/views"),
            $this->name
        );

        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        $apiRoutesPath = modules_path("{$this->name}/routes/api_v1.php");
        if (file_exists($apiRoutesPath) && !$this->app->routesAreCached()) {
            Route::prefix('api/v1')
                ->middleware('web')
                ->name('api.v1.')
                ->namespace($this->getControllerNamespace() . '\API\v1')
                ->group(modules_path("{$this->name}/routes/api_v1.php"));
        }
    }
}
