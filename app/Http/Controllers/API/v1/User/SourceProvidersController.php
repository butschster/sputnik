<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\User\SourceProvidersCollection;
use Domain\SourceProvider\Contracts\Registry;
use Domain\SourceProvider\Events\Disconnected;
use Domain\SourceProvider\ValueObjects\SourceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SourceProvidersController extends Controller
{
    /**
     * @param Request $request
     * @return SourceProvidersCollection
     */
    public function connected(Request $request): SourceProvidersCollection
    {
        return SourceProvidersCollection::make(
            $request->user()->sourceProviders
        );
    }

    /**
     * @param Request $request
     * @param string $provider
     * @return JsonResponse
     */
    public function unlink(Request $request, string $provider): JsonResponse
    {
        $provider = $request->user()->sourceProviders()->where('id', $provider)->firstOrFail();
        $provider->delete();

        event(new Disconnected($provider->type, $request->user()));

        return $this->responseDeleted();
    }

    /**
     * Get list of available source providers
     *
     * @param Registry $registry
     *
     * @return array
     */
    public function available(Registry $registry): array
    {
        return $registry->all()->map(function (SourceProvider $provider) {
            return [
                'type' => $provider->getType(),
                'name' => $provider->getName(),
                'links' => [
                    'connect' => route('provider.connect', $provider->getType()),
                ]
            ];
        })->all();
    }
}
