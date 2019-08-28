<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\User\RolesCollection;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => 'https://api.adorable.io/avatars/161/abott@adorable.png',
            'roles' => $this->whenLoaded('roles', function() {
                return RolesCollection::make($this->roles);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
