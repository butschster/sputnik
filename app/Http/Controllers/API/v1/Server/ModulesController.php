<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Registry;
use App\Contracts\Server\Modules\Repository;
use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\Module\StoreRequest;
use App\Http\Resources\v1\Server\ModulesCollection;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ModulesController extends Controller
{
    /**
     * @var Repository
     */
    protected $repository;
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @param Repository $repository
     * @param Registry $registry
     */
    public function __construct(Repository $repository, Registry $registry)
    {
        $this->repository = $repository;
        $this->registry = $registry;
    }

    /**
     * @param Registry $registry
     *
     * @return \Illuminate\Support\Collection
     */
    public function index(Registry $registry)
    {
        return $registry->modules();
    }

    /**
     * @param Server $server
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function installed(Server $server): ModulesCollection
    {
        $this->authorize('show', $server);

        return ModulesCollection::make($server->modules);
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function install(StoreRequest $request, Server $server)
    {
        $request->persist();

       return $this->responseOk();
    }

    /**
     * @param Request $request
     * @param Server\Module $module
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function uninstall(Request $request, Server\Module $module)
    {
        $this->authorize('update', $module->server);

        $this->repository->uninstall($module);

        return $this->responseOk();
    }

    /**
     * @param Request $request
     * @param Server\Module $module
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function restart(Request $request, Server\Module $module)
    {
        $this->authorize('update', $module->server);

        $this->repository->restart($module);

        return $this->responseOk();
    }

    /**
     * @param Request $request
     * @param Server\Module $module
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function start(Request $request, Server\Module $module)
    {
        $this->authorize('update', $module->server);

        $this->repository->start($module);

        return $this->responseOk();
    }

    /**
     * @param Request $request
     * @param Server\Module $module
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\Server\ModuleNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function stop(Request $request, Server\Module $module)
    {
        $this->authorize('update', $module->server);

        $this->repository->stop($module);

        return $this->responseOk();
    }
}
