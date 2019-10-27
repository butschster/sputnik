<?php

namespace Domain\SourceProvider;

use App\Models\User\SourceProvider;
use Domain\SourceProvider\Contracts\SourceProvider as SourceProviderContract;
use Domain\SourceProvider\Exceptions\SourceProviderNotFoundException;
use Domain\SourceProvider\Providers\Bitbucket;
use Domain\SourceProvider\Providers\Github;

class Factory
{
    /**
     * Create a source control provider client instance for the given provider.
     *
     * @param SourceProvider $source
     * @return SourceProviderContract
     */
    public function make(SourceProvider $source): SourceProviderContract
    {
        switch (strtolower($source->type)) {
            case 'github':
                return new Github($source);
            case 'bitbucket':
                return new Bitbucket($source);
        }

        throw new SourceProviderNotFoundException('Invalid source control provider type.');
    }
}
