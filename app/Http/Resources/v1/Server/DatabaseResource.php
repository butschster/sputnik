<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\Database;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Database
 */
class DatabaseResource extends JsonResource
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
            'server_id' => $this->server_id,
            'name' => $this->name,
            'password' => $this->password,
            'character_set' => $this->character_set,
            'collation' => $this->collation,
            'task' => TaskResource::make($this->task),
            'created_at' => $this->created_at,
        ];
    }
}
