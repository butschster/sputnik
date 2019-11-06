<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\User\StoreRequest;
use App\Http\Controllers\Controller;
use Domain\SourceProvider\Contracts\Registry;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @param Registry $registry
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Registry $registry)
    {
        return view('auth.register', [
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

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function register(StoreRequest $request)
    {
        event(new Registered($user = $request->persist()));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
