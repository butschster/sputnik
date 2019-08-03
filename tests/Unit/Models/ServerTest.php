<?php

namespace Tests\Unit\Models;

use App\Models\Server;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ServerTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_key_pair_sould_be_generated_when_server_is_creating()
    {
        $this->mockSshGenerator();

        $server = factory(Server::class)->create();

        $this->assertEquals('key', $server->public_key);
        $this->assertEquals('key', $server->private_key);
        $this->assertNotNull($server->key_password);
    }

    function test_a_key_pair_should_not_be_generated_when_it_set()
    {
        $server = factory(Server::class)->create([
            'public_key' => 'key',
            'private_key' => 'key',
            'key_password' => 'password'
        ]);

        $this->assertEquals('key', $server->public_key);
        $this->assertEquals('key', $server->private_key);
        $this->assertEquals('password', $server->key_password);
    }
}
