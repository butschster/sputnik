<?php

namespace Module\OpenVPN\Http\Resources\v1;

use App\Http\Resources\v1\Server\RecordResource;
use App\Models\Server\Record;

/**
 * @mixin Record
 */
class ClientResource extends RecordResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['links'] = [
            'download' => api_route('server.openvpn.client.download', $this->id)
        ];

        return $data;
    }
}
