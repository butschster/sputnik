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
            'user_id' => $user->id
        ]);

        $server1 = $this->createServer([
            'user_id' => $user->id
        ]);

        $server2 = $this->createServer();

        $this->assertTrue($user->servers->contains($server));
        $this->assertTrue($user->servers->contains($server1));
        $this->assertFalse($user->servers->contains($server2));
    }
}
