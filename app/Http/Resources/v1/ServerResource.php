<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\User\TeamResource;
use App\Models\Server;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

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
            'sys_info' => $this->when(!empty($sysInfo), function () use ($sysInfo) {
                return [
                    'name' => $sysInfo->getFullName(),
                    'os' => $sysInfo->getOs(),
                    'version' => $sysInfo->getVersion(),
                    'architecture' => $sysInfo->getArchitecture(),
                    'is_supported' => $sysInfo->isSupported(),
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
            'links' => [
                'install_script' => route('server.install_script', $this),
            ],
            'can' => [
                'show' => Gate::allows('show', $this->resource),
                'update' => Gate::allows('update', $this->resource),
                'delete' => Gate::allows('delete', $this->resource),

                'create_site' => Gate::allows('store', [\App\Models\Server\Site::class, $this->resource]),
                'create_cron_job' => Gate::allows('store', [\App\Models\Server\CronJob::class, $this->resource]),
                'create_database' => Gate::allows('store', [\App\Models\Server\Database::class, $this->resource]),
                'create_firewall' => Gate::allows('store', [\App\Models\Server\Firewall\Rule::class, $this->resource]),
                'create_daemon' => Gate::allows('store', [\App\Models\Server\Daemon::class, $this->resource]),
                'create_user' => Gate::allows('store', [\App\Models\Server\User::class, $this->resource]),
            ]
        ];
    }
}
