<?php

namespace App\Http\Resources\v1\Server\Firewall;

use App\Models\Server\Firewall\Rule;
use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\Parent_;

/**
 * @mixin Rule
 */
class RuleResource extends JsonResource
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
            'protocol' => $this->protocol(),
            'policy' => $this->policy(),
            'created_at' => $this->created_at,
            'from' => $this->hasFrom() ? $this->from() : 'any',
            'port' => $this->port(),
            'status' => $this->taskStatus(),
            'is_editable' => $this->editable,

        ];
    }
}
