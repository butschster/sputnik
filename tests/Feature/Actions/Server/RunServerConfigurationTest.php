<?php

namespace Tests\Feature\Actions\Server;

use Domain\Server\Jobs\Configure;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class RunServerConfigurationTest extends TestCase
{
    use DatabaseMigrations;

    // Server ID is required
    function test_server_id_is_required()
    {
        $this->sendCallbackRequest('server.keys_installed')
            ->assertJsonValidationErrors(['server_id']);
    }

    // Server should exist
    function test_server_should_exist()
    {
        $this->sendCallbackRequest('server.keys_installed', [
            'server_id' => 'abs'
        ])->assertJsonValidationErrors(['server_id']);
    }

    function test_if_server_has_not_status_pending_show_page_not_found_response()
    {
        $server = $this->createServer();
        $server->markAsConfiguring();

        $this->sendCallbackRequest('server.keys_installed', [
            'server_id' => $server->id,
        ])->assertNotFound();
    }

    function test_fire_job_when_keys_installed()
    {
        Bus::fake();

        $server = $this->createServer();

        $this->sendCallbackRequest('server.keys_installed', [
            'server_id' => $server->id,
        ])->assertOk();

        Bus::assertDispatched(Configure::class);
    }
}
