<?php

namespace App\Http\Resources\v1\Server\Firewall;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RulesCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     * @var string
     */
    public $collects = RuleResource::class;

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
