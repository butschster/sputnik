<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\User\SourceProvidersCollection;
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
        $request->user()->sourceProviders()->where('id', $provider)->delete();

        return $this->responseDeleted();
    }

    /**
     * Get list of available source providers
     *
     * @return array
     */
    public function available(): array
    {
        return collect(config('source_providers'))->map(function ($provider) {
            $provider['links'] = [
                'connect' => route('login.'.$provider['type']),
            ];

            return $provider;
        })->all();
    }
}
