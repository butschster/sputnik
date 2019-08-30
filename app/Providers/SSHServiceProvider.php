<?php

namespace App\Providers;

use App\Services\Task\Contracts\ExecutorService as ExecutorServiceContract;
use App\Services\Task\ExecutorService;
use App\Utils\SSH\Commands\SshKeygen;
use App\Utils\SSH\Contracts\KeyGenerator as KeyGeneratorContract;
use App\Utils\SSH\Contracts\KeyStorage;
use App\Utils\SSH\Contracts\ProcessExecutor as ProcessExecutorContract;
use App\Utils\SSH\Fake\FakeExecutorService;
use App\Utils\SSH\Fake\FakeKeyGenerator;
use App\Utils\SSH\Fake\FakeKeyStorage;
use App\Utils\SSH\Fake\FakeProcessExecutor;
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

        if ($this->app->runningUnitTests()) {
            $this->registerForTesting();

            return;
        }

        $this->registerForProduction();
    }

    protected function registerForProduction(): void
    {
        $this->app->singleton(ExecutorServiceContract::class, function () {
            return new ExecutorService(
                $this->app[ProcessExecutorContract::class]
            );
        });

        $this->app->singleton(KeyStorage::class, function () {
            return new FilesystemKeyStorage(
                new \Illuminate\Filesystem\Filesystem()
            );
        });

        $this->app->singleton(ProcessExecutorContract::class, function () {
            return new ProcessExecutor();
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

    protected function registerForTesting(): void
    {
        $this->app->singleton(ExecutorServiceContract::class, function () {
            return new FakeExecutorService();
        });

        $this->app->singleton(KeyStorage::class, function () {
            return new FakeKeyStorage();
        });

        $this->app->singleton(ProcessExecutorContract::class, function () {
            return new FakeProcessExecutor();
        });

        $this->app->singleton(KeyGeneratorContract::class, function () {
            return new FakeKeyGenerator();
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
