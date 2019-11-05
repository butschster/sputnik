<?php

namespace App\Http\Resources\v1\User;

use App\Models\User\SourceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SourceProvider
 */
class SourceProviderResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'links' => [
                'refresh' => route('provider.connect', $this->type),
            ]
        ];
    }
}
