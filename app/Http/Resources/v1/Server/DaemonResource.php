<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\Daemon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

/**
 * @mixin Daemon
 */
class DaemonResource extends JsonResource
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
            'directory' => $this->directory,
            'command' => $this->command,
            'user' => $this->user,
            'processes' => $this->processes,
            'task' => TaskResource::make($this->task),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'can' => [
                'show' => Gate::allows('show', $this->resource),
                'delete' => Gate::allows('delete', $this->resource),
            ]
        ];
    }
}
