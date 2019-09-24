<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Repository;
use App\Http\Controllers\API\Controller;

class ModulesController extends Controller
{
    /**
     * @param Repository $modulesRepository
     *
     * @return \Illuminate\Support\Collection
     */
    public function index(Repository $modulesRepository)
    {
        return $modulesRepository->collection()->groupBy(function (Module $module) {
            return $module->categories();
        });
    }
}
