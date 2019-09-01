<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\User\TeamsCollection;
use App\Http\Resources\v1\User\TeamWithSubscriptionResource;
use App\Models\User\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * @param Request $request
     * @return TeamsCollection
     */
    public function index(Request $request): TeamsCollection
    {
        $teams = $request->user()->rolesTeams;

        return TeamsCollection::make($teams);
    }

    /**
     * @param Request $request
     * @param Team $team
     * @return TeamWithSubscriptionResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Team $team): TeamWithSubscriptionResource
    {
        $this->authorize('show', $team);

        return TeamWithSubscriptionResource::make($team);
    }
}