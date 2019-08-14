<?php

namespace App\Services\SourceProviders;

use App\Exceptions\Repository\SourceProviderNotFoundException;
use App\Models\User\SourceProvider;
use App\Services\SourceProviders\Contracts\SourceProvider as SourceProviderContract;

class Factory
{
    /**
     * Create a source control provider client instance for the given provider.
     *
     * @param SourceProvider $source
     * @return SourceProviderContract
     */
    public function make(SourceProvider $source)
    {
        switch (strtolower($source->type)) {
            case 'github':
                return new Github($source);
            case 'bitbucket':
                return new Bitbucket($source);
        }

        throw new SourceProviderNotFoundException("Invalid source control provider type.");
    }
}
