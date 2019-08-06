<?php

namespace Tests\Feature\Actions\Server;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProcessServerEventsTest extends TestCase
{
    use DatabaseMigrations;

    // Server ID is required
    function test_server_id_is_required()
    {
        $this->postJson($this->callbackUrl(), ['action' => 'server.event', 'message' => 'test'])
            ->assertJsonValidationErrors(['server_id']);
    }

    // Server should exist
    function test_server_should_exist()
    {
        $this->postJson($this->callbackUrl(), ['action' => 'server.event', 'server_id' => 'abc', 'message' => 'test'])
            ->assertJsonValidationErrors(['server_id']);
    }

    // Message is required
    function test_message_is_required()
    {
        $this->postJson($this->callbackUrl(), ['action' => 'server.event', 'server_id' => 'abc'])
            ->assertJsonValidationErrors(['message']);
    }

    // Valid event should be stored
    function test_valid_event_should_be_stored()
    {
        $server = $this->createServer();

        $this->postJson($this->callbackUrl(), ['action' => 'server.event', 'server_id' => $server->id, 'message' => 'test'])->assertOk();

        $this->assertEquals('test', $server->events()->first()->message);
    }
}
