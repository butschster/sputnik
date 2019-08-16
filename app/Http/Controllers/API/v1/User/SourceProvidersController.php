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

    /**
     * @return array
     */
    public function available()
    {
        return ['github', 'bitbucket'];
    }
}
