<?php

namespace Tests\Unit\Services\SourceProviders;

use App\Services\SourceProviders\Bitbucket;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BitbucketTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_clone_url()
    {
        $provider = new Bitbucket(
            $this->createSourceProvider()
        );

        $this->assertEquals('git@bitbucket.org:test/repo.git', $provider->cloneUrl('test/repo'));
    }
}
