<?php

namespace App\Providers;

use App\Contracts\Server\Modules\Registry as RegistryContract;
use App\Contracts\Server\Modules\Repository as RepositoryContract;
use App\Server\Modules\BaseSettings;
use App\Server\Modules\PHP;
use App\Server\Modules\Database;
use App\Server\Modules\Repository;
use App\Server\Modules\Security;
use App\Server\Modules\Javascript;
use App\Server\Modules\Registry;
use App\Server\Modules\Tools;
use Illuminate\Support\ServiceProvider;

class ServerModulesServiceProvider extends ServiceProvider
{
    /**
     * Available server modules
     *
     * @var array
     */
    protected $modules = [
        BaseSettings::class,
        
        PHP\PHP58::class,
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

        Tools\Supervisor::class,

        Javascript\NodeJs::class,
        Javascript\Yarn::class,
    ];

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RegistryContract::class, function ($app) {
            $registry = new Registry();

            foreach ($this->modules as $module) {
                $registry->register(
                    $app->make($module)
                );
            }

            return $registry;
        });

        $this->app->singleton(RepositoryContract::class, function () {
            return new Repository(
                $this->app[RegistryContract::class]
            );
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
