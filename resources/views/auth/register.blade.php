@extends('layouts.blank')

@section('content')
<main class="page-login-container">
    <div class="form-container">
        <h1>{{ __('Register') }}</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group form-group-labeled @error('project_name') is-invalid @enderror">
                <input id="project_name" type="text"
                       class="form-control form-control-lg"
                       name="project_name" value="{{ old('project_name') }}" placeholder="{{ __('Project name') }}"
                       autofocus>
                <label for="project_name">{{ __('Project name') }}</label>

                @error('project_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group form-group-labeled @error('name') is-invalid @enderror">
                <input id="name" type="text" class="form-control"
                       name="name" value="{{ old('name') }}" placeholder="{{ __('Name') }}">

                <label for="name">{{ __('Name') }}</label>

                @error('name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group form-group-labeled @error('email') is-invalid @enderror">
                <input id="email" type="email" class="form-control"
                       name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}">
                <label for="email">{{ __('E-Mail Address') }}</label>

                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="flex">
                <div class="form-group form-group-labeled mr-3 @error('password') is-invalid @enderror">
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

                <div class="form-group form-group-labeled">
                    <input id="password-confirm" type="password" class="form-control"
                           name="password_confirmation" placeholder="{{ __('Confirm Password') }}">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                </div>
            </div>

            <button type="submit" class="btn btn-block btn-primary btn-shadow">
                <i class="fa fa-check fa-lg fa-fw"></i> {{ __('Register') }}
            </button>
        </form>
    </div>
    <p class="my-4 mx-auto text-white">Already have an account?
        <a class="text-white underline hover:text-white" href="{{ route('login') }}"> Sign In</a>
    </p>
</main>
@endsection
