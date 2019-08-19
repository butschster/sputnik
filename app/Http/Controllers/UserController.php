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
            'teams' => $request->user()->rolesTeams,
        ]);
    }
}
