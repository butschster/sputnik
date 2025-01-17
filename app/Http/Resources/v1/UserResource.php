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
            'lang' => $this->lang,
            'avatar' => 'https://icon-library.net/images/avatar-icon-images/avatar-icon-images-4.jpg',
            'roles' => $this->whenLoaded('roles', function() {
                return RolesCollection::make($this->roles);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
