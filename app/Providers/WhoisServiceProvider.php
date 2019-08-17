<?php

namespace App\Providers;

use App\Contracts\Server\Site\WhoisService as WhoisServiceContract;
use App\Services\Server\Site\WhoisService;
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
