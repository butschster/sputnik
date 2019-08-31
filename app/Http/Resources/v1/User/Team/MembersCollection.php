<?php

namespace App\Http\Resources\v1\User\Team;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MembersCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     * @var string
     */
    public $collects = MemberResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
