<?php

namespace Module\Supervisor\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DaemonsCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     * @var string
     */
    public $collects = DaemonResource::class;

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
