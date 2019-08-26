<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\User\TeamResource;
use App\Models\Server;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Server
 */
class ServerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $sysInfo = $this->systemInformation();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'ip' => $this->ip,
            'ssh_port' => $this->ssh_port,
            'sys_info' => $this->when(!empty($sysInfo), function() use($sysInfo) {
                return [
                    'name' => $sysInfo->getOs(),
                    'version' => $sysInfo->getVersion(),
                    'architecture' => $sysInfo->getArchitecture(),
                    'supported' => $sysInfo->isSupported(),
                ];
            }),
            'php_version' => $this->php_version,
            'database_type' => $this->database_type,
            'webserver_type' => $this->webserver_type,
            'public_key' => $this->public_key,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'team' => TeamResource::make($this->whenLoaded('team')),
            'owner' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
