<?php

namespace App\Http\Resources\v1;

use App\Models\Script;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Script
 */
class ScriptResource extends JsonResource
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
