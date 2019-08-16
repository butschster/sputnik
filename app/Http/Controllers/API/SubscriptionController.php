<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\v1\PlanCollection;
use App\Http\Resources\v1\SubscriptionResource;
use App\Models\User;
use Illuminate\Http\Request;
use Rennokki\Plans\Models\PlanModel;

class SubscriptionController extends Controller
{
    /**
     * @return PlanCollection
     */
    public function plans(): PlanCollection
    {
        $plans = PlanModel::with('features')->get();

        return PlanCollection::make($plans);
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function cancel(Request $request)
    {
        $this->authorize('cancel-subscription', User::class);

        $request->user()->cancelCurrentSubscription();

        return ['status' => 'on'];
    }

    /**
     * @param Request $request
     * @param PlanModel $plan
     * @return SubscriptionResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function subscribe(Request $request, PlanModel $plan): SubscriptionResource
    {
        $this->authorize('subscribe', User::class);

        $subscription = $request->user()->upgradeCurrentPlanTo($plan);

        return SubscriptionResource::make($subscription);
    }
}
