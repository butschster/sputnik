<?php

namespace Tests\Feature\Actions\Server;

use App\Jobs\Server\ConfigureServer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class RunServerConfigurationTest extends TestCase
{
    use DatabaseMigrations;

    // Server ID is required
    function test_server_id_is_required()
    {
        $this->postJson($this->callbackUrl(), ['action' => 'server.keys_installed'])
            ->assertJsonValidationErrors(['server_id']);
    }

    // Server should exist
    function test_server_should_exist()
    {
        $this->postJson($this->callbackUrl(), ['action' => 'server.keys_installed', 'server_id' => 'abs'])
            ->assertJsonValidationErrors(['server_id']);
    }

    function test_fire_job_when_keys_installed()
    {
        Bus::fake();

        $server = $this->createServer();

        $this->postJson($this->callbackUrl(), [
            'action' => 'server.keys_installed',
            'server_id' => $server->id,
        ])->assertOk();

        Bus::assertDispatched(ConfigureServer::class);
    }
}
