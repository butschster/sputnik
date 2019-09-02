<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\Site;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

/**
 * @mixin Site
 */
class SiteResource extends JsonResource
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
            'server_id' => $this->server_id,
            'domain' => $this->domain,
            'aliases' => $this->aliases,
            'public_dir' => $this->public_dir,
            'public_path' => $this->publicPath(),
            'path' => $this->path(),
            'domain_expires_at' => $this->domain_expires_at,
            'use_ssl' => $this->use_ssl,
            'ssl_certificate_expires_at' => $this->ssl_certificate_expires_at,
            'task' => TaskResource::make($this->task),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                'url' => $this->url(),
                'secure_url' => $this->secureUrl(),
                'hooks_url' => $this->hooksHandlerUrl(),
            ],
            'can' => [
                'deploy' => Gate::allows('deploy', $this->resource),
                'push-deploy' => Gate::allows('push-deploy', $this->resource),
                'update' => Gate::allows('update', $this->resource),
                'show' => Gate::allows('show', $this->resource),
                'delete' => Gate::allows('delete', $this->resource),
            ]
        ];
    }
}
