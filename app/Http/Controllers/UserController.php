<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Rennokki\Plans\Models\PlanModel;

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
            'subscription' => $request->user()->activeSubscription()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'plan' => ['required', 'numeric', Rule::exists('plans', 'id')],
        ]);

        $request->user()->subscribeTo(
            PlanModel::findOrFail($request->plan)
        );

        return back();
    }

    public function cancelSubscription(Request $request)
    {
        $request->user()->cancelCurrentSubscription();

        return back();
    }
}
