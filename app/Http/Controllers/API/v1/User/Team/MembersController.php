<?php

namespace App\Http\Controllers\API\v1\User\Team;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\UserCollection;
use App\Models\User\Team;

class MembersController extends Controller
{
    /**
     * @param Team $team
     * @return UserCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Team $team): UserCollection
    {
        $this->authorize('show', $team);

        return UserCollection::make(
            $team->users()->with('roles')->get()
        );
    }
}