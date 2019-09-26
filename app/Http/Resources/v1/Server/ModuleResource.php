<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\Module;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Module
 */
class ModuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $module = $this->toModule();

        return [
            'id' => $this->id,
            'server_id' => $this->server_id,
            'meta' => $this->meta,
            'status' => $this->status,
            'key' => $module->key(),
            'title' => $module->title(),
            'categories' => $module->categories(),
            'dependencies' => $module->dependencies(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
