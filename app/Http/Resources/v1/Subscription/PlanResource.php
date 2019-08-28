<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\Subscription\Plan\FeaturesCollection;
use App\Models\Subscription\Plan;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Plan
 */
class PlanResource extends JsonResource
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
            'key' => $this->name,
            'is_active' => $this->is_active,
            'price' => $this->price,
            'is_free' => $this->isFree(),
            'trial_period' => $this->trial_period,
            'features' => FeaturesCollection::make($this->features),
        ];
    }
}
