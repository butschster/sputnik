<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\User\SourceProvidersCollection;
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

    public function unlink(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|string'
        ]);

        $request->user()->sourceProvider()->where('type', $request->type)->firstOrFail();


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
