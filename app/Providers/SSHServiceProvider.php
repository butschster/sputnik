<?php

namespace App\Providers;

use App\Utils\SSH\Commands\SshKeygen;
use App\Utils\SSH\Contracts\KeyGenerator as KeyGeneratorContract;
use App\Utils\SSH\Contracts\KeyStorage;
use App\Utils\SSH\Contracts\ProcessExecutor as ProcessExecutorContract;
use App\Utils\SSH\FilesystemKeyStorage;
use App\Utils\SSH\KeyGenerator;
use App\Utils\SSH\ProcessExecutor;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class SSHServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProcessExecutorContract::class, function () {
            return new ProcessExecutor();
        });

        $this->app->singleton(KeyStorage::class, function () {
            return new FilesystemKeyStorage;
        });

        $this->app->singleton(KeyGeneratorContract::class, function () {
            return new KeyGenerator(
                $this->app[Filesystem::class],
                new SshKeygen(
                    $this->app[\App\Utils\SSH\Contracts\ProcessExecutor::class]
                )
            );
        });
    }

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot()
    {
        //
    }
}
