<?php

namespace App\Http\Controllers;

use App\Contracts\Modules\ManagerInterface as ModulesManager;
use App\Http\Resources\v1\UserProfileResource;
use App\Modules\Module;
use Illuminate\Http\Request;

class SpaController extends Controller
{
    /**
     * @param Request $request
     * @param ModulesManager $manager
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request, ModulesManager $manager)
    {
        return view('app', [
            'user' => UserProfileResource::make($request->user()),
            'modules' => $manager->getModules()->map(function (Module $module) {
                return [
                    'name' => $module->getName(),
                    'bootstrap' => file_exists($module->getPath('resources/js/bootstrap.js')),
                ];
            }),
        ]);
    }
}