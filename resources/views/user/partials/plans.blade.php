<div class="price-table">
    <h2>Available plans</h2>
    <div class="price-table__items">
        @foreach($plans as $plan)
            <div class="price-table__item @if($subscription->hasPlan($plan)) current @endif  @if($subscription->canBeUpgradeTo($plan)) changeable @endif">
                <div>
                    <h3 class="price-table__item--title">{{ ucfirst($plan->name) }}
                        @if(!$plan->isFree())
                            <strong class="ml-3">${{ $plan->price }}</strong> <span class="text-xs">/mo</span>
                        @endif
                    </h3>
                    <ul class="price-table__item--features">
                        @foreach($plan->features as $feature)
                            <li class="price-table__item--feature">
                                <i class="icon fas fa-check-circle "></i> {{ $feature->name() }}
                                @if(!$feature->isUnlimited())
                                    [{{ $feature->value }} times]
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                @if($subscription->canBeUpgradeTo($plan))
                    <div class="text-center mt-5">
                        <button class="btn btn-primary btn-rounded btn-lg">Order now</button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>