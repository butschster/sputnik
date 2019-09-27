<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SchemaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blueprint::macro('primaryUuid', function ($column) {
            $this->uuid($column)->primary();
        });

        Blueprint::macro('belongsToServer', function () {
            $this->uuid('server_id')->index();

            $this->foreign('server_id')
                ->references('id')
                ->on('servers')
                ->onDelete('cascade');
        });

        Blueprint::macro('belongsToModule', function () {
            $this->uuid('module_id')->index();

            $this->foreign('module_id')
                ->references('id')
                ->on('server_modules')
                ->onDelete('cascade');
        });

        Blueprint::macro('belongsToUser', function () {
            $this->uuid('user_id')->index();
            $this->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Blueprint::macro('belongsToTeam', function () {
            $this->uuid('team_id')->index();
            $this->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');
        });
    }
}
