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
                            <i class="fas fa-check text-success mr-3"></i> {{ $feature->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
