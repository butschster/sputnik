<?php

namespace App\Http\Resources\v1\User;

use App\Http\Resources\v1\SubscriptionResource;
use App\Models\User\Team;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Team
 */
class TeamWithSubscriptionResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'subscription' => SubscriptionResource::make($this->getActiveSubscription()),
            'has_payment_method' => $this->hasPaymentMethod(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
