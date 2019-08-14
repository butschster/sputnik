<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_servers()
    {
        $user = $this->createUser();

        $server = $this->createServer([
            'user_id' => $user->id,
        ]);

        $server1 = $this->createServer([
            'user_id' => $user->id,
        ]);

        $server2 = $this->createServer();

        $this->assertTrue($user->servers->contains($server));
        $this->assertTrue($user->servers->contains($server1));
        $this->assertFalse($user->servers->contains($server2));
    }

    function test_get_source_providers()
    {
        $user = $this->createUser();

        $provider = $this->createSourceProvider([
            'user_id' => $user->id,
        ]);

        $provider1 = $this->createSourceProvider([
            'user_id' => $user->id,
        ]);

        $provider2 = $this->createSourceProvider();

        $this->assertTrue($user->sourceProviders->contains($provider));
        $this->assertTrue($user->sourceProviders->contains($provider1));
        $this->assertFalse($user->sourceProviders->contains($provider2));
    }
}
