<?php

namespace App\Providers;

use App\Http\Actions\Contracts\Manager as ManagerContract;
use App\Http\Actions\Manager;
use App\Http\Actions\Server\ProcessServerEvents;
use App\Http\Actions\Server\RegisterNewKey;
use App\Http\Actions\Server\RunServerConfiguration;
use App\Http\Actions\Server\StoreServerInformation;
use App\Http\Actions\Task\FinishTask;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    /**
     * Action list that will be used when remote server sends
     * callback with action name
     *
     * @var array
     */
    protected $actions = [
        'server.information' => StoreServerInformation::class,
        'server.event' => ProcessServerEvents::class,
        'server.key' => RegisterNewKey::class,
        'server.keys_installed' => RunServerConfiguration::class,
        'task.finished' => FinishTask::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ManagerContract::class, function () {
            return new Manager($this->actions);
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
