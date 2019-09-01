<?php

namespace App\Http\Controllers\API\v1\Server;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\Server\Firewall\StoreRequest;
use App\Http\Resources\v1\Server\Firewall\RuleResource;
use App\Http\Resources\v1\Server\Firewall\RulesCollection;
use App\Models\Server;

class FirewallController extends Controller
{
    /**
     * @param Server $server
     * @return RulesCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Server $server): RulesCollection
    {
        $this->authorize('show', $server);

        $rules = $server->firewallRules()->get();

        return RulesCollection::make($rules);
    }

    /**
     * @param Server\Firewall\Rule $rule
     * @return RuleResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Server\Firewall\Rule $rule): RuleResource
    {
        $this->authorize('show', $rule);

        return RuleResource::make($rule);
    }

    /**
     * @param StoreRequest $request
     * @param Server $server
     * @return RuleResource
     */
    public function store(StoreRequest $request, Server $server): RuleResource
    {
        $rule = $request->persist();

        return RuleResource::make($rule);
    }

    /**
     * @param Server\Firewall\Rule $rule
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Server\Firewall\Rule $rule)
    {
        $this->authorize('delete', $rule);

        $rule->delete();

        return $this->responseDeleted();
    }
}
