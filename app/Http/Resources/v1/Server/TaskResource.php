<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\Task;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Task
 */
class TaskResource extends JsonResource
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
        return [
            'id' => $this->id,
            'server_id' => $this->server_id,
            'name' => $this->name,
            'status' => $this->status,
            'is_successful' => $this->isSuccessful(),
            'exit_code' => $this->exit_code,
            'exit_code_text' => $this->getExitCodeText(),
            'script_file' => $this->scriptFile(),
            'output_file' => $this->outputFile(),
            'user' => $this->user(),
            'timeout' => $this->timeout(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
