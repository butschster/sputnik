<?php

namespace App\Http\Resources\v1;

use App\Models\User\Subscription;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Subscription
 */
class SubscriptionResource extends JsonResource
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
            'is_valid' => $this->valid(),
            'is_cancelled' => $this->cancelled(),
            'is_recurring' => $this->recurring(),
            'plan' => PlanResource::make($this->plan),
            'trial_ends_at' => $this->trial_ends_at,
            'ends_at' => $this->ends_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
