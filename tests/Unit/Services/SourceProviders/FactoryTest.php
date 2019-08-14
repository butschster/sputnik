<?php

namespace Tests\Unit\Services\SourceProviders;

use App\Exceptions\Repository\SourceProviderNotFoundException;
use App\Services\SourceProviders\Bitbucket;
use App\Services\SourceProviders\Factory;
use App\Services\SourceProviders\Github;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use DatabaseMigrations;

    function test_bitbucket_provider_should_be_made()
    {
        $factory = new Factory();
        $provider = $this->createSourceProvider([
            'type' => 'bitbucket'
        ]);

        $this->assertInstanceOf(Bitbucket::class, $factory->make($provider));
    }

    function test_github_provider_should_be_made()
    {
        $factory = new Factory();
        $provider = $this->createSourceProvider([
            'type' => 'github'
        ]);

        $this->assertInstanceOf(Github::class, $factory->make($provider));
    }

    function test_throw_an_exception_if_provider_not_found()
    {
        $this->expectException(SourceProviderNotFoundException::class);

        $factory = new Factory();
        $provider = $this->createSourceProvider([
            'type' => 'unknown'
        ]);

        $factory->make($provider);
    }
}
