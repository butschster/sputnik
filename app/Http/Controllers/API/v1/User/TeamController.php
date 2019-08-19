<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\User\TeamResource;
use App\Http\Resources\v1\User\TeamsCollection;
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
        $teams = $request->user()->rolesTeams();

        return TeamsCollection::make($teams);
    }

    /**
     * @param Request $request
     * @param Team $team
     * @return TeamResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Team $team): TeamResource
    {
        $this->authorize('show', $team);

        return TeamResource::make($team);
    }
}