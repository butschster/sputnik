<?php

namespace Domain\SourceProvider\Providers;

use Domain\SourceProvider\Contracts\Registry as RegistryContract;
use Domain\SourceProvider\Registry;
use Domain\SourceProvider\ValueObjects\SourceProvider;
use Illuminate\Support\ServiceProvider;

class SourceProvidersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RegistryContract::class, function () {
            $registry = new Registry();

            $registry->register(new SourceProvider(
                'github', ['repo', 'user:email', 'write:public_key', 'read:public_key', 'admin:repo_hook']
            ));

            $registry->register(new SourceProvider('bitbucket'));

            return $registry;
        });
    }
}
