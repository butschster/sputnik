<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\User\SourceProvidersCollection;
use App\Http\Resources\v1\User\TeamResource;
use App\Http\Resources\v1\User\TeamsCollection;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

/**
 * @mixin User
 */
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
            'company' => $this->company,
            'address' => $this->address,
            'teams' => TeamsCollection::make($this->rolesTeams),
            'team' => TeamResource::make($this->team),
            'has_active_subscription' => $this->hasActiveSubscription(),
            'source_providers' => SourceProvidersCollection::make($this->sourceProviders),
            'can' => [
                'server_create' => Gate::allows('create', \App\Models\Server::class),
            ],
        ];
    }
}
