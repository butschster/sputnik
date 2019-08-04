<?php

namespace Tests\Feature\Server;

use App\Events\Server\KeysInstalled;
use App\Jobs\Server\ConfigureServer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CallbackTest extends TestCase
{
    use DatabaseMigrations;

    function test_received_public_keys_should_be_stored()
    {
        $server = $this->createServer();

        $this->postJson(route('server.callback', $server), [
            'event' => 'server.key',
            'key' => $publicKey = $this->getPublicKey(),
        ])->assertOk();


        $key = $server->keys->first();

        $this->assertEquals($publicKey, $key->content);
    }

    function test_received_public_keys_should_be_ignored()
    {
        $server = $this->createServer();

        $this->postJson(route('server.callback', $server), [
            'event' => 'server.key',
            'key' => '',
        ])->assertOk();

        $this->assertCount(0, $server->keys);
    }

    function test_fire_job_when_keys_installed()
    {
        Bus::fake();

        $server = $this->createServer();

        $this->postJson(route('server.callback', $server), [
            'event' => 'server.keys_installed',
        ])->assertOk();

        Bus::assertDispatched(ConfigureServer::class);
    }
}
