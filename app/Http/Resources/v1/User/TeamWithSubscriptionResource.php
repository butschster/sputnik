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
        $subscription = $this->getActiveSubscription();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_trial_period' => $subscription->onTrial(),
            'is_cancelled' => $subscription->cancelled(),
            'is_ended' => $subscription->ended(),
            'subscription' => SubscriptionResource::make($subscription),
            'has_payment_method' => $this->hasPaymentMethod(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
