<div class="card-deck mt-4">
    @foreach($plans as $plan)
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="my-0">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="plan{{ $plan->id }}"
                               name="plan"
                               class="custom-control-input"
                               value="{{ $plan->id }}"
                               @if($plan->name == 'artisan') checked @endif
                        >
                        <label class="custom-control-label" for="plan{{ $plan->id }}">{{ $plan->name }}</label>

                        @if(!$plan->isFree())
                           <div class="float-right"> ${{ $plan->price }} <small class="text-muted">/mo</small></div>
                        @endif
                    </div>
                </h4>
                <small class="text-muted">{{ $plan->description }}</small>
            </div>
            <div class="card-body px-5 py-3">
                <ul class="list-unstyled mt-3 mb-4">
                    @foreach($plan->features as $feature)
                        <li>
                            <i class="fas fa-check text-success mr-3"></i> {{ $feature->name() }}
                        @if(!$feature->isUnlimited())
                                [{{ $feature->value }} times]
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
