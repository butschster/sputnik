<?php

namespace App\Http\Resources\v1\User\Team;

use App\Http\Resources\v1\UserResource;

class MemberResource extends UserResource
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