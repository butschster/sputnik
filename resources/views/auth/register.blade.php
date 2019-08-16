@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>


                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row">
                                <div class="form-group col">
                                    <label for="name">{{ __('Name') }}</label>

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col">
                                    <label for="email">{{ __('E-Mail Address') }}</label>

                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label for="password">{{ __('Password') }}</label>

                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>

                                <div class="form-group col">
                                    <label for="password-confirm">{{ __('Confirm Password') }}</label>

                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="card-deck mt-4">
                                @foreach(\Rennokki\Plans\Models\PlanModel::get() as $plan)
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h4 class="my-0">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="plan{{ $plan->id }}"
                                                           name="plan"
                                                           class="custom-control-input"
                                                           value="{{ $plan->id }}"
                                                           @if($plan->name == 'Artisan') checked @endif
                                                    >
                                                    <label class="custom-control-label" for="plan{{ $plan->id }}">{{ $plan->name }}</label>
                                                </div>
                                            </h4>
                                            <small class="text-muted">{{ $plan->description }}</small>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title pricing-card-title">${{ $plan->price }} <small class="text-muted">/mo</small></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                                @foreach($plan->features as $feature)
                                                <li>
                                                    <i class="fas fa-check text-success"></i> <strong>{{ $feature->description }}</strong>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
