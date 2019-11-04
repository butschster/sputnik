<?php

namespace App\Http\Resources\v1\Server\Site;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class EnvironmentResource extends JsonResource
{
    protected $masks = [
        'PASSWORD',
        'SECRET',
        'KEY',
    ];

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if (is_null($this->resource)) {
            return [];
        }

        return $this->maskSecretVariables($this->resource);
    }

    /**
     * @param array $env
     *
     * @return array
     */
    private function maskSecretVariables(array $env): array
    {
        foreach ($env as $key => $value) {
            if (Str::contains($key, $this->masks)) {
                $env[$key] = '**********';
            }
        }

        return $env;
    }
}