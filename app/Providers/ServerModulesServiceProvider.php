<?php

namespace App\Providers;

use App\Contracts\Server\Modules\Repository as RepositoryContract;
use App\Server\Modules\PHP;
use App\Server\Modules\Database;
use App\Server\Modules\Security;
use App\Server\Modules\Javascript;
use App\Server\Modules\Repository;
use Illuminate\Support\ServiceProvider;

class ServerModulesServiceProvider extends ServiceProvider
{
    /**
     * Available server modules
     * @var array
     */
    protected $modules = [
        PHP\PHP59::class,
        PHP\PHP72::class,
        PHP\PHP73::class,
        PHP\Composer::class,
        PHP\Deployer::class,

        Database\MySQL5::class,
        Database\MySQL8::class,
        Database\MariaDB::class,
        Database\PostgreSQL::class,
        Database\MongoDB::class,
        Database\Redis::class,

        Security\Fail2Ban::class,
        Security\Ufw::class,

        Javascript\NodeJs::class,
        Javascript\Yarn::class,
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RepositoryContract::class, function ($app) {
            $repository = new Repository();

            foreach ($this->modules as $module) {
                $repository->register(
                    $app->make($module)
                );
            }

            return $repository;
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
        //
    }
}
