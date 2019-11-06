@extends('layouts.blank')

@section('content')
<main class="page-login-container">
    <div class="form-container">
        <h1>@lang('auth.form.register.title')</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group form-group-labeled @error('project_name') is-invalid @enderror">
                <input id="project_name" type="text"
                       class="form-control form-control-lg"
                       name="project_name"
                       value="{{ old('project_name') }}"
                       placeholder="@lang('auth.form.register.project')"
                       autofocus>
                <label for="project_name">@lang('auth.form.register.project')</label>

                @error('project_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group form-group-labeled @error('name') is-invalid @enderror">
                <input id="name" type="text" class="form-control"
                       name="name" value="{{ old('name') }}" placeholder="@lang('auth.form.register.name')">

                <label for="name">@lang('auth.form.register.name')</label>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group form-group-labeled @error('email') is-invalid @enderror">
                <input id="email" type="email" class="form-control"
                       name="email" value="{{ old('email') }}" placeholder="@lang('auth.form.register.email')">
                <label for="email">@lang('auth.form.register.email')</label>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group form-group-labeled @error('password') is-invalid @enderror">
                <input id="password" type="password"
                       class="form-control" name="password"
                       placeholder="@lang('auth.form.register.password')">
                <label for="password">@lang('auth.form.register.password')</label>

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group form-group-labeled">
                <input id="password-confirm"
                       type="password"
                       class="form-control"
                       name="password_confirmation"
                       placeholder="@lang('auth.form.register.password_confirm')">
                <label for="password-confirm">@lang('auth.form.register.password_confirm')</label>
            </div>

            <button type="submit" class="btn btn-block btn-primary btn-shadow">
                <i class="fa fa-check fa-lg fa-fw"></i>
                @lang('auth.form.register.button.register')
            </button>

            <small class="block text-gray-600 uppercase text-center mt-4 font-medium">
                @lang('auth.form.register.sign_up_with_provider')
            </small>

            <div class="flex w-full mt-5">
                @foreach($providers as $provider)
                    <a class="btn btn-{{ $provider->getType() }} w-full @if(!$loop->last) mr-4 @endif" href="{{ route('provider.register', $provider->getType()) }}">
                        <i class="fab {{ $provider->getIcon() }} fa-lg fa-fw"></i>
                        {{ $provider->getName() }}
                    </a>
                @endforeach
            </div>
        </form>
    </div>
    <p class="my-4 mx-auto text-white">
        @lang('auth.form.register.have_account')
        <a class="text-white underline hover:text-white" href="{{ route('login') }}">
            @lang('auth.form.register.button.login')
        </a>
    </p>
</main>
@endsection
