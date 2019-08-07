<?php

namespace App\Providers;

use App\Contracts\Request\RequestSignatureHandler as RequestSignatureHandlerContract;
use App\Http\Requests\RequestSignatureHandler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RequestSignatureHandlerContract::class, function () {
            return new RequestSignatureHandler(config('app.key'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
