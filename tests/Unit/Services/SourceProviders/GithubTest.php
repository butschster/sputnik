<?php

namespace Tests\Unit\Services\SourceProviders;

use Domain\SourceProvider\Providers\Github;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GithubTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_clone_url()
    {
        $provider = new Github(
            $this->createSourceProvider()
        );

        $this->assertEquals('git@github.com:test/repo.git', $provider->cloneUrl('test/repo'));
    }

    function test_get_token()
    {

    }
}
