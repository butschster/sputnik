<?php

namespace Module\Supervisor\Http\Resources\v1;

use App\Http\Resources\v1\Server\RecordResource;
use Illuminate\Support\Facades\Gate;
use Module\Supervisor\Models\Daemon;

/**
 * @mixin Daemon
 */
class DaemonResource extends RecordResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['can'] = [
            'show' => Gate::allows('show', $this->resource),
            'delete' => Gate::allows('delete', $this->resource),
        ];

        return $data;
    }
}
