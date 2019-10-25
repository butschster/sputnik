<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\Deployment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Deployment
 */
class DeploymentResource extends JsonResource
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
        return [
            'id' => $this->id,
            'site_id' => $this->server_site_id,
            'initiator_id' => $this->initiator_id,
            'status' => $this->status,
            'owner' => $this->owner,
            'task' => TaskResource::make($this->task),
            'is_ended' => $this->hasEnded(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
