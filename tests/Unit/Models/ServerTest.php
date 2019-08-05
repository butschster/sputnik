<?php

namespace Tests\Unit\Models;

use App\Models\Server;
use App\Utils\SSH\Contracts\KeyStorage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ServerTest extends TestCase
{
    use DatabaseMigrations;

    function test_the_database_password_should_be_generated()
    {
        $server = $this->createServer([
            'database_password' => null
        ]);

        $this->assertNotNull($server->database_password);
    }

    function test_a_server_should_have_pending_status_when_created()
    {
        $server = $this->createServer();

        $this->assertEquals(Server::STATUS_PENDING, $server->status);
        $this->assertTrue($server->isPending());
    }

    function test_check_if_server_is_configuring()
    {
        $server = $this->createServer();

        $this->assertFalse($server->isConfiguring());
        $this->assertNull($server->configuring_job_dispatched_at);
        $server->markAsConfiguring();
        $server->refresh();
        $this->assertEquals(Server::STATUS_CONFIGUTING, $server->status);
        $this->assertTrue($server->isConfiguring());
        $this->assertNotNull($server->configuring_job_dispatched_at);
        $this->assertFalse($server->isConfigured());
    }

    function test_check_if_server_is_configured()
    {
        $server = $this->createServer();

        $this->assertFalse($server->isConfigured());
        $server->markAsConfigured();
        $server->refresh();
        $this->assertEquals(Server::STATUS_CONFIGURED, $server->status);
        $this->assertTrue($server->isConfigured());
    }

    function test_a_key_path_can_be_generated()
    {
        $server = $this->createServer();

        $this->mock(KeyStorage::class, function ($mock) {
            $mock->shouldReceive('storeKey')->once()->andReturn('key_path');
        });

        $server->keyPath();
    }

    function test_a_key_pair_sould_be_generated_when_server_is_creating()
    {
        $server = $this->createServer();

        $this->assertEquals($this->getPublicKey(), $server->public_key);
        $this->assertEquals($this->getPrivateKey(), $server->private_key);
        $this->assertNotNull($server->key_password);
    }

    function test_a_key_pair_should_not_be_generated_when_it_set()
    {
        $server = $this->createServer([
            'public_key' => 'key',
            'private_key' => 'key',
            'key_password' => 'password',
        ]);

        $this->assertEquals('key', $server->public_key);
        $this->assertEquals('key', $server->private_key);
        $this->assertEquals('password', $server->key_password);

        $this->assertTrue($server->hasKeyPair());
    }

    function test_it_has_tasks()
    {
        $server = $this->createServer();

        $task = $this->createTask([
            'server_id' => $server->id,
        ]);
        $task1 = $this->createTask([
            'server_id' => $server->id,
        ]);
        $task2 = $this->createTask();

        $this->assertTrue($server->tasks->contains($task));
        $this->assertTrue($server->tasks->contains($task1));
        $this->assertFalse($server->tasks->contains($task2));
    }

    function test_it_has_ssh_keys()
    {
        $server = $this->createServer();

        $key = $this->createServerKey();
        $key1 = $this->createServerKey();
        $key2 = $this->createServerKey();

        $server->keys()->attach($key);
        $server->keys()->attach($key1);

        $this->assertTrue($server->keys->contains($key));
        $this->assertTrue($server->keys->contains($key1));
        $this->assertFalse($server->keys->contains($key2));
    }

    function test_a_public_key_can_be_created()
    {
        $server = $this->createServer();

        $server->addPublicKey($this->createServerKey());

        $this->assertCount(1, $server->keys);
    }

    function test_a_public_key_can_be_removed()
    {
        $server = $this->createServer();

        $server->addPublicKey($key = $this->createServerKey());

        $server->removePublicKey($key);

        $this->assertCount(0, $server->keys);

    }
}
