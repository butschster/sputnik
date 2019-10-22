<?php

namespace Module\Supervisor\Http\Resources\v1;

use App\Http\Resources\v1\Server\RecordResource;
use App\Models\Server\Record;
use Illuminate\Support\Facades\Gate;

/**
 * @mixin Record
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
