<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Script\ExecuteRequest;
use App\Http\Requests\Script\StoreRequest;
use App\Http\Requests\Script\UpdateRequest;
use App\Http\Resources\v1\ScriptCollection;
use App\Http\Resources\v1\ScriptResource;
use App\Models\Script;
use Illuminate\Http\Request;
use App\Services\Task\Factory;

class ScriptsController extends Controller
{
    /**
     * @param Request $request
     *
     * @return ScriptCollection
     */
    public function index(Request $request): ScriptCollection
    {
        return ScriptCollection::make($request->user()->scripts);
    }

    /**
     * @return ScriptCollection
     */
    public function public(): ScriptCollection
    {
        $scripts = Script::latest()->onlyPublic()->paginate(50);

        return ScriptCollection::make($scripts);
    }

    /**
     * @param Script $script
     *
     * @return ScriptResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Script $script): ScriptResource
    {
        $this->authorize('show', $script);

        return ScriptResource::make($script);
    }

    /**
     * @param StoreRequest $request
     *
     * @return ScriptResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRequest $request): ScriptResource
    {
        $script = $request->persist();

        return ScriptResource::make($script);
    }

    /**
     * @param UpdateRequest $request
     * @param Script $script
     *
     * @return ScriptResource
     */
    public function update(UpdateRequest $request, Script $script): ScriptResource
    {
        $request->persist();

        return ScriptResource::make($script);
    }

    /**
     * @param Factory $taskFactory
     * @param ExecuteRequest $request
     * @param Script $script
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function execute(Factory $taskFactory, ExecuteRequest $request, Script $script)
    {
        $request->persist($taskFactory);

        return $this->responseOk();
    }

    /**
     * @param Script $script
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Script $script)
    {
        $this->authorize('delete', $script);

        $script->delete();

        return $this->responseDeleted();
    }

}
