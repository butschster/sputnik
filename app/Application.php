<?php

namespace App;

use App\Modules\Manifest as ModulesManifest;
use Illuminate\Filesystem\Filesystem;
use App\Contracts\Modules\ManagerInterface as ModulesManagerContract;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Application extends \Illuminate\Foundation\Application
{
    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registerBaseBindings()
    {
        parent::registerBaseBindings();

        $this->instance(ModulesManifest::class, new ModulesManifest(
            new Filesystem, $this->basePath(), $this->bootstrapPath().'/cache/modules.php'
        ));

        $this->singleton(ModulesManagerContract::class, function () {
            return new \App\Modules\Manager($this);
        });
    }

    public function registerConfiguredProviders()
    {
        $providers = Collection::make($this->config['app.providers'])
            ->partition(function ($provider) {
                return Str::startsWith($provider, 'Illuminate\\');
            });

        $providers->splice(1, 0, [$this->make(PackageManifest::class)->providers()]);
        $providers->push($this->make(ModulesManifest::class)->providers());

        (new ProviderRepository($this, new Filesystem, $this->getCachedServicesPath()))
            ->load($providers->collapse()->toArray());
    }
}