@extends('layouts.blank')

@section('content')
    <main class="page-login-container">
        <div class="form-container">
            <h1>{{ __('Reset Password') }}</h1>

            <form class="py-4 px-8 w-full" method="POST" action="{{ route('password.email') }}">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @csrf

                <div class="form-group form-group-labeled">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" autofocus placeholder="{{ __('E-Mail Address') }}">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary shadow-xl">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
