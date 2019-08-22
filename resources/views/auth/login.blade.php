@extends('layouts.blank')

@section('content')
    <main class="page-login-container">
        <div class="form-container">
            <h1>Sign In</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group form-group-labeled @error('email') is-invalid @enderror">
                    <input id="email" type="email" class="form-control"
                           placeholder="{{ __('E-Mail Address') }}" name="email">
                    <label for="email">{{ __('E-Mail Address') }}</label>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group form-group-labeled @error('password') is-invalid @enderror">
                    <input id="password" type="password"
                           class="form-control" name="password"
                           placeholder="{{ __('Password') }}">

                    <label for="password">{{ __('Password') }}</label>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <div class="form-group form-group-checkbox>
                        <input class="form-checkbox" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label ml-2" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-blue btn-shadow">
                        {{ __('Login') }}
                    </button>
                </div>

                <small class="block text-gray-600 uppercase text-center mb-4 font-medium">
                    Or sing in with
                </small>

                <div class="flex w-full justify-center">
                    <a class="btn btn-outline mr-4" href="{{ route('login.github') }}">
                        <i class="fab fa-github-alt"></i>
                        Github
                    </a>
                    <a class="btn btn-outline" href="{{ route('login.bitbucket') }}">
                        <i class="fab fa-bitbucket"></i>
                        Bitbucket
                    </a>
                </div>
            </form>
        </div>
        <p class="my-4 mx-auto text-white">Don't have an account?
            <a class="text-white underline" href="{{ route('register') }}">Create one now</a>
        </p>
    </main>
@endsection
