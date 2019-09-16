<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\Task;

/**
 * @mixin Task
 */
class TaskWithContentResource extends TaskResource
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
        return parent::toArray($request) + [
            'script' => $this->script(),
            'output' => $this->output,
        ];
    }
}
