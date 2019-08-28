<?php

namespace App\Http\Resources\v1\User;

use App\Models\User\Team;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Team
 */
class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
