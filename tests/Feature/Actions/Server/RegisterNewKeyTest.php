<?php

namespace Tests\Feature\Actions\Server;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RegisterNewKeyTest extends TestCase
{
    use DatabaseMigrations;

    // Server ID is required
    function test_server_id_is_required()
    {
        $this->sendCallbackRequest('server.key', [
            'key' => 'test'
        ])->assertJsonValidationErrors(['server_id']);
    }

    // Server should exist
    function test_server_should_exist()
    {
        $this->sendCallbackRequest('server.key', [
            'server_id' => 'abs',
            'key' => 'test'
        ])->assertJsonValidationErrors(['server_id']);
    }

    function test_key_is_required()
    {
        $this->sendCallbackRequest('server.key')
            ->assertJsonValidationErrors(['key']);
    }

    function test_key_should_be_valid_public_key()
    {
        $this->sendCallbackRequest('server.key', [
            'server_id' => 'abs',
            'key' => 'test'
        ])->assertJsonValidationErrors(['key']);
    }

    function test_received_public_keys_should_be_stored()
    {
        $server = $this->createServer();

        $this->sendCallbackRequest('server.key', [
            'server_id' => $server->id,
            'key' => $publicKey = $this->getPublicKey(),
        ])->assertOk();

        $key = $server->keys->first();

        $this->assertEquals($publicKey, $key->content);
    }

    function test_an_empty_received_public_keys_should_be_ignored()
    {
        $server = $this->createServer();
        $this->sendCallbackRequest('server.key', [
            'server_id' => $server->id,
            'key' => '',
        ])->assertJsonValidationErrors(['key']);

        $this->assertCount(0, $server->keys);
    }

}
