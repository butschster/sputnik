<?php

namespace Domain\Site\Providers;

use Domain\Site\Entities\Domain\WhoisService;
use Domain\Site\Contracts\WhoisService as WhoisServiceContract;
use Illuminate\Support\ServiceProvider;
use Iodev\Whois\Whois;

class WhoisServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WhoisServiceContract::class, function () {
            return new WhoisService(
                Whois::create()
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
