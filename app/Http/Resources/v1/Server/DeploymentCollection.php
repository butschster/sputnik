<?php

namespace App\Http\Resources\v1\Server;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DeploymentCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     * @var string
     */
    public $collects = DeploymentResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
