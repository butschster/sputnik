<?php

namespace Tests\Feature\API\v1;

use App\Events\Server\PublicKey\AttachedToServer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ServerKeysControllerTest extends TestCase
{
    use DatabaseMigrations;

    // A guest cannot create keys
    function test_a_guest_cannot_create_keys()
    {
        $server = $this->createServer();

        $this->postJson(api_route('server.key.store', $server), [
            'name' => 'test', 'content' => 'test',
        ])->assertUnauthorized();
    }

    // An authenticated user can create keys for own servers
    function test_an_authenticated_user_can_create_keys_for_own_servers()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $response = $this->postJson(api_route('server.key.store', $server), [
            'name' => 'test', 'content' => $this->getPublicKey(),
        ])->assertCreated();

        $key = $server->keys()->first();

        $response->assertJson([
            'data' => [
                'name' => $key->name,
                'content' => $key->content,
            ],
        ]);
    }

    // An authenticated user cannot create keys for foreign servers
    function test_an_authenticated_user_can_create_keys_for_foreign_servers()
    {
        $this->signInAPI();
        $server = $this->createServer();

        $this->postJson(api_route('server.key.store', $server), [
            'name' => 'test', 'content' => $this->getPublicKey(),
        ])->assertForbidden();
    }

    // Name is required
    function test_name_is_required()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $this->postJson(api_route('server.key.store', $server), [
            'content' => $this->getPublicKey(),
        ])->assertJsonValidationErrors('name');
    }

    // Key is required
    function test_content_is_required()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $this->postJson(api_route('server.key.store', $server), [
            'name' => 'test',
        ])->assertJsonValidationErrors('content');
    }

    // Key should be valid public key
    function test_content_should_be_a_valid_public_key()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $this->postJson(api_route('server.key.store', $server), [
            'name' => 'test', 'content' => 'test',
        ])->assertJsonValidationErrors('content');
    }

    // Key should be unique for given server
    function test_content_should_be_unique_for_the_given_server()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);
        $key = $this->createSSHKeyForServer($server, [
            'content' => $this->getPublicKey(),
        ]);

        $this->postJson(api_route('server.key.store', $server), [
            'name' => 'test', 'content' => $key->content,
        ])->assertJsonValidationErrors('content');

        $server = $this->createServer(['user_id' => $user]);
        $key = $this->createSSHKey([
            'content' => $this->getPublicKey(),
        ]);
        $this->postJson(api_route('server.key.store', $server), [
            'name' => 'test', 'content' => $key->content,
        ])->assertCreated();
    }

    function test_an_event_should_fired_when_key_is_stored()
    {
        Event::fake(AttachedToServer::class);

        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $this->postJson(api_route('server.key.store', $server), [
            'name' => 'test', 'content' => $this->getPublicKey(),
        ])->assertCreated();

        Event::assertDispatched(AttachedToServer::class, function ($event) use ($server) {
            return $server->is($event->key->server);
        });
    }

    // A guest cannot remove keys
    function test_a_guest_cannot_remove_keys()
    {
        $key = $this->createSSHKey();

        $this->deleteJson(api_route('server.key.delete', $key))->assertUnauthorized();
    }

    // An authenticated user can remove keys on own servers
    function test_an_authenticated_user_can_remove_keys_on_own_servers()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);
        $key = $this->createSSHKeyForServer($server);

        $this->deleteJson(api_route('server.key.delete', $key))->assertDeleted();

        $this->assertCount(0, $server->keys);
    }

    // An authenticated user cannot remove keys on foreign servers
    function test_an_authenticated_user_cannot_remove_keys_on_foreign_servers()
    {
        $this->signInAPI();
        $server = $this->createServer();
        $key = $this->createSSHKeyForServer($server);

        $this->deleteJson(api_route('server.key.delete', $key))->assertForbidden();

        $this->assertCount(1, $server->keys);
    }
}
