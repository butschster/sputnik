<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\Alert;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Alert
 */
class AlertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'level' => $this->level,
            'type' => $this->type,
            'message' => $this->message()
        ];
    }
}
