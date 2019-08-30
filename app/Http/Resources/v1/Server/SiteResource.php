<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\Site;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                'url' => $this->url(),
                'secure_url' => $this->secureUrl(),
                'hooks_url' => $this->hooksHandlerUrl(),
            ]
        ];
    }
}
