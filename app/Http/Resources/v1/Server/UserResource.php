<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

/**
 * @mixin User
 */
class UserResource extends JsonResource
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
            'sudo_password' => $this->sudo_password,
            'public_key' => $this->public_key,
            'home_dir' => $this->homeDir(),
            'is_sudo' => $this->sudo,
            'is_root' => $this->isRoot(),
            'is_system' => $this->isSystem(),
            'task' => TaskResource::make($this->task),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                'download_key' => api_route('server.user.download_key', $this->id)
            ],
            'can' => [
                'show' => Gate::allows('show', $this->resource),
                'delete' => Gate::allows('delete', $this->resource),
            ]
        ];
    }
}
