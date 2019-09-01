<?php

namespace App\Http\Resources\v1\Server;

use App\Models\Server\CronJob;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'name' => $this->name,
            'cron' => $this->cron,
            'user' => $this->user,
            'command' => $this->command,
            'next_run_at' => $this->nextRunDate(),
            'status' => $this->taskStatus(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
