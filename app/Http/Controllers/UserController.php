<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        return view('user.profile', [
            'user' => $request->user(),
            'subscription' => $request->user()->activeSubscription()
        ]);
    }
}
