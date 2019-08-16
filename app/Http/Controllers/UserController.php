<?php

namespace App\Http\Controllers;

use App\Models\Subscription\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(Request $request)
    {
        return view('user.profile', [
            'user' => $request->user(),
            'plans' => Plan::orderBy('sort_order')->onlyActive()->get(),
            'subscription' => $request->user()->subscription,
        ]);
    }

    public function renew(Request $request)
    {
        $request->user()->subscription->renew();

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'plan' => ['required', Rule::exists('plans', 'id')],
        ]);

        $plan = Plan::findOrFail($request->plan);
        $plan->trial_period = 0;
        $request->user()->subscribeTo(
            $plan
        );

        return back();
    }

    public function cancelSubscription(Request $request)
    {
        $request->user()->cancelCurrentSubscription();

        return back();
    }
}
