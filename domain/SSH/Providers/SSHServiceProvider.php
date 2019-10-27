<?php

namespace Domain\SSH\Providers;

use Domain\Task\Contracts\ExecutorService as ExecutorServiceContract;
use Domain\Task\Services\ExecutorService;
use Domain\SSH\Bash\SshKeygen;
use Domain\SSH\Contracts\KeyGenerator as KeyGeneratorContract;
use Domain\SSH\Contracts\KeyStorage;
use Domain\SSH\Contracts\ProcessExecutor as ProcessExecutorContract;
use Tests\Fake\SSH\FakeExecutorService;
use Tests\Fake\SSH\FakeKeyGenerator;
use Tests\Fake\SSH\FakeKeyStorage;
use Tests\Fake\SSH\FakeProcessExecutor;
use Domain\SSH\FilesystemKeyStorage;
use Domain\SSH\Services\KeyGenerator;
use Domain\SSH\Services\ProcessExecutor;
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
                    $this->app[\Domain\SSH\Contracts\ProcessExecutor::class]
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
