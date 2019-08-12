<?php

namespace Tests\Feature\API\v1\Server\PublicKeys;

use App\Events\Server\PublicKey\AttachedToServer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DeleteActionTest extends TestCase
{
    use DatabaseMigrations;

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
