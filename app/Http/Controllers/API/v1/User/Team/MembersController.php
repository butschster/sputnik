<?php

namespace App\Http\Controllers\API\v1\User\Team;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\User\Team\MembersCollection;
use App\Http\Resources\v1\UserCollection;
use App\Models\User\Team;

class MembersController extends Controller
{
    /**
     * @param Team $team
     * @return MembersCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Team $team): MembersCollection
    {
        $this->authorize('show', $team);

        return MembersCollection::make(
            $team->users()->with('roles')->get()
        );
    }
}