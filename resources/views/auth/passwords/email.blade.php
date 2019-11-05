@extends('layouts.blank')

@section('content')
    <main class="page-login-container">
        <div class="form-container">
            <h1>@lang('auth.form.reset_password_email.title')</h1>

            <form class="py-4 px-8 w-full" method="POST" action="{{ route('password.email') }}">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                @csrf

                <div class="form-group form-group-labeled">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"

                           name="email"
                           value="{{ old('email') }}"
                           autofocus
                           placeholder="@lang('auth.form.reset_password_email.email')">

                    <label for="email" class="col-md-4 col-form-label text-md-right">
                        @lang('auth.form.reset_password_email.email')
                    </label>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary shadow-xl">
                        @lang('auth.form.reset_password_email.button.reset')
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
