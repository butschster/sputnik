<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\CronJob;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

/**
 * @mixin CronJob
 */
class CronJobResource extends JsonResource
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
            'name' => $this->name,
            'cron' => $this->cron,
            'user' => $this->user,
            'command' => $this->command,
            'next_run_at' => $this->nextRunDate(),
            'task' => TaskResource::make($this->task),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'can' => [
                'show' => Gate::allows('show', $this->resource),
                'delete' => Gate::allows('delete', $this->resource),
            ]
        ];
    }
}
