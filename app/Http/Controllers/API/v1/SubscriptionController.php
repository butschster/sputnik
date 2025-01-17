<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\PlanCollection;
use App\Http\Resources\v1\PlanResource;
use App\Http\Resources\v1\SubscriptionResource;
use App\Models\Subscription\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * @return PlanCollection
     */
    public function plans(): PlanCollection
    {
        return PlanCollection::make(
            Plan::onlyActive()->orderBy('sort_order')->get()
        );
    }

    /**
     * @param Request $request
     * @param User\Team $team
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function cancel(Request $request, User\Team $team)
    {
        $this->authorize('cancel-subscription', $team);

        $team->cancelCurrentSubscription();

        return $this->responseOk();
    }

    /**
     * @param Request $request
     * @param User\Team $team
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function resume(Request $request, User\Team $team)
    {
        $this->authorize('resume-subscription', $team);

        $team->resumeCurrentSubscription();

        return $this->responseOk();
    }

    /**
     * @param Request $request
     * @param User\Team $team
     * @param Plan $plan
     * @return SubscriptionResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Laravel\Cashier\Exceptions\SubscriptionUpdateFailure
     */
    public function subscribe(Request $request, User\Team $team, Plan $plan): SubscriptionResource
    {
        $this->authorize('subscribe', $team);

        $subscription = $team->subscribeTo(
            $plan
        );

        return SubscriptionResource::make($subscription);
    }
}
