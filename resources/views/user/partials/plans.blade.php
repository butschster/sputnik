<div class="my-8">
    <h2 class="font-light">Available plans</h2>
    <div class="flex justify-center">
        @foreach($plans as $plan)
            <div class="flex flex-col justify-between @if($subscription->hasPlan($plan)) border-4 border-green-400  @else border  @endif bg-white transition @if($subscription->canBeUpgradeTo($plan)) hover:shadow-2xl @endif w-1/4 p-8 mr-8 rounded-lg">
                <div>
                    <h3 class="mb-6 text-2xl">{{ ucfirst($plan->name) }}
                        @if(!$plan->isFree())
                            <strong class="ml-3">${{ $plan->price }}</strong> <span class="text-xs">/mo</span>
                        @endif
                    </h3>
                    <ul class="list-unstyled mt-3 mb-4">
                        @foreach($plan->features as $feature)
                            <li class="font-bold text-gray-600">
                                <i class="fas fa-check-circle text-green-400 py-3 mr-3"></i> {{ $feature->name() }}
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