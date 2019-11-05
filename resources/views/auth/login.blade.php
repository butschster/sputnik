@extends('layouts.blank')

@section('content')
    <main class="page-login-container">
        <div class="form-container">
            <h1>@lang('auth.form.login.title')</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group form-group-labeled @error('email') is-invalid @enderror">
                    <input id="email" type="email" class="form-control" value="{{ old('email') }}" placeholder="@lang('auth.form.login.email')" name="email">
                    <label for="email">@lang('auth.form.login.email')</label>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group form-group-labeled @error('password') is-invalid @enderror">
                    <input id="password" type="password" class="form-control" name="password" placeholder="@lang('auth.form.login.password')">

                    <label for="password">@lang('auth.form.login.password')</label>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <div class="form-group form-group-checkbox">
                        <input class="form-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label ml-2" for="remember">
                            @lang('auth.form.login.remember_me')
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            @lang('auth.form.login.button.forgot_password')
                        </a>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary btn-shadow">
                        <i class="fas fa-plug fa-lg fa-fw"></i>
                        @lang('auth.form.login.button.login')
                    </button>
                </div>

                <small class="block text-gray-600 uppercase text-center mb-4 font-medium">
                    @lang('auth.form.login.sign_in_with_provider')
                </small>

                <div class="flex w-full">
                    @foreach(config('source_providers', []) as $provider)
                    <a class="btn btn-{{ $provider['type'] }} w-full @if(!$loop->last) mr-4 @endif" href="{{ route('provider.login', $provider['type']) }}">
                        <i class="fab {{ $provider['icon'] }} fa-lg fa-fw"></i>
                        @lang('auth.provider.'.$provider['type'])
                    </a>
                    @endforeach
                </div>
                @error('provider')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </form>
        </div>
        <p class="my-4 mx-auto text-white">
            @lang('auth.form.login.no_account')
            <a class="text-white underline hover:text-white" href="{{ route('register') }}">
                @lang('auth.form.login.button.register')
            </a>
        </p>
    </main>
@endsection
