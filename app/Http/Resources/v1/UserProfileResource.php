<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\User\TeamsCollection;
use Illuminate\Support\Facades\Gate;

class UserProfileResource extends UserResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request) + [
            'email' => $this->email,
            'teams' => TeamsCollection::make($this->rolesTeams),
            'can' => [
                'server_create' => Gate::allows('create', \App\Models\Server::class),
            ],
        ];
    }
}
