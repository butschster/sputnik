<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\SourceProvider\Contracts\Registry;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @param Registry $registry
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Registry $registry)
    {
        return view('auth.login', [
            'providers' => $registry->all()
        ]);
    }

    /**
     * @return string
     */
    public function redirectTo(): string
    {
        return route('app');
    }
}
