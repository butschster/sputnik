<?php

namespace App\Http\Resources\v1\Server\OpenVPN;

use App\Http\Resources\v1\Server\TaskResource;
use App\Models\Server\OpenVPN\Client;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Client
 */
class ClientResource extends JsonResource
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
            'task' => TaskResource::make($this->task),
            'created_at' => $this->created_at,
            'links' => [
                'download' => api_route('server.openvpn.client.download', $this->id)
            ]
        ];
    }
}
