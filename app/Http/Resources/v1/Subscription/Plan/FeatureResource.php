<?php

namespace App\Http\Resources\v1\Subscription\Plan;

use App\Models\Subscription\Plan\Feature;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Feature
 */
class FeatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name(),
            'code' => $this->code,
            'value' => $this->value,
            'is_unlimited' => $this->isUnlimited(),
            'is_renewable' => $this->renewable,
        ];
    }
}
