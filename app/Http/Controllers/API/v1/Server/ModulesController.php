<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\Module\RunActionRequest;
use App\Http\Resources\v1\Server\ModulesCollection;
use App\Models\Server;
use Domain\Module\Contracts\Entities\Module\Repository;
use Domain\Module\Contracts\Registry;
use Domain\Module\Entities\Module\Collection;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        return $this->registry->modules();
    }

    /**
     * @param Request $request
     * @param Server $server
     * @return ModulesCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function installed(Request $request, Server $server): ModulesCollection
    {
        $this->authorize('show', $server);

        $this->validate($request, [
            'categories' => 'nullable|array',
            'categories.*' => 'string',
        ]);

        $modules = $server->modules;

        if ($request->has('categories')) {
            $modules = Collection::forServer($server)
                ->filterByCategories($request->categories)
                ->toCollection();
        }

        return ModulesCollection::make($modules);
    }

    /**
     * @param RunActionRequest $request
     * @param Server $server
     * @return \Illuminate\Http\JsonResponse
     */
    public function runAction(RunActionRequest $request, Server $server)
    {
        $request->persist();

        return $this->responseOk();
    }

    /**
     * @param Request $request
     * @param Server $server
     * @param string $module
     * @param string $action
     * @return string
     * @throws \Domain\Module\Exceptions\ModuleNotFoundException
     */
    public function script(Request $request, Server $server, string $module, string $action)
    {
        return $this->registry->get($module)->getAction($action)->render($server);
    }
}
