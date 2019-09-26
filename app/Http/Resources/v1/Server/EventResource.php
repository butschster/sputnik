<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\Event;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Event
 */
class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if (!$this instanceof Event) {
            return [];
        }

        return [
            'id' => $this->id,
            'server_id' => $this->server_id,
            'message' => trans('event.' . $this->message),
            'key' => $this->message,
            'meta' => $this->meta,
            'created_at' => $this->created_at,
        ];
    }
}
