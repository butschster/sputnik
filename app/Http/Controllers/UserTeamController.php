<?php

namespace App\Http\Controllers;

use App\Models\Subscription\Plan;
use App\Models\User\Team;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserTeamController extends Controller
{
    public function show(Team $team)
    {
        return view('user.team.show', [
            'team' => $team,
            'users' => $team->users,
            'plans' => Plan::orderBy('sort_order')->onlyActive()->get(),
            'subscription' => $team->subscription,
        ]);
    }

    public function renew(Request $request)
    {
        $request->user()->subscription->renew();

        return back();
    }

    /**
     * @param Request $request
     * @param Team $team
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function subscribe(Request $request, Team $team)
    {
        $this->validate($request, [
            'plan' => ['required', Rule::exists('plans', 'id')],
        ]);

        $plan = Plan::findOrFail($request->plan);
        $plan->trial_period = 0;
        $team->subscribeTo(
            $plan
        );

        return back();
    }

    /**
     * @param Request $request
     * @param Team $team
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelSubscription(Request $request, Team $team)
    {
        $team->cancelCurrentSubscription();

        return back();
    }
}
