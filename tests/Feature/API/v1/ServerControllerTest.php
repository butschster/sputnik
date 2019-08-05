<?php

namespace Tests\Feature\API\v1;

use App\Observers\Server\GenerateSshKeyPairsObserver;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Tests\TestCase;

class ServerControllerTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_guest_cannot_see_servers()
    {
        $this->getJson(route('api.v1.servers'))->assertUnauthorized();
    }

    // An authenticated user can see only own servers
    function test_an_authenticated_user_can_see_only_own_servers()
    {
        $user = $this->signInAPI();
        $servers = $this->createServer([
            'user_id' => $user->id,
        ], 2);

        $serversForeign = $this->createServer([], 2);

        $response = $this->getJson(route('api.v1.servers'));
        $response->assertOk();

        $response->assertJson([
            'data' => $servers->only('id')->toArray(),
        ]);

        $response->assertJsonMissing([
            'data' => $serversForeign->only('id')->toArray(),
        ]);
    }

    function test_a_guest_cannot_view_information_about_server()
    {
        $server = $this->createServer();

        $this->getJson(route('api.v1.server.show', $server))->assertUnauthorized();
    }

    // An authenticated user can view information about own server
    function test_an_authenticated_user_can_view_information_only_about_own_server()
    {
        $user = $this->signInAPI();
        $server = $this->createServer([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson(route('api.v1.server.show', $server));
        $response->assertOk();

        $response->assertJson([
            'data' => [
                'id' => $server->id,
            ],
        ]);

        // An authenticated user can not view information about foreigner server
        $serverForeign = $this->createServer();
        $this->getJson(route('api.v1.server.show', $serverForeign))->assertForbidden();
    }

    function test_a_guest_cannot_create_server()
    {
        $server = $this->createServer();

        $this->postJson(route('api.v1.server.store'))->assertUnauthorized();
    }

    // An authenticated user can create server
    function test_an_authenticated_user_can_create_server()
    {
        $user = $this->signInAPI();

        $response = $this->postJson(route('api.v1.server.store'), [
            'name' => 'Server name',
            'ip' => '127.0.0.1',
            'ssh_port' => 22,
            'sudo_password' => $password = Str::random(),
            'meta' => [],
            'php_version' => '72',
            'database_type' => 'mysql',
        ]);

        $response->assertStatus(201);

        $server = $user->servers()->first();

        $this->assertEquals('Server name', $server->name);
        $this->assertEquals('127.0.0.1', $server->ip);
        $this->assertEquals('22', $server->ssh_port);
        $this->assertEquals($password, $server->sudo_password);
        $this->assertEquals('72', $server->php_version);
        $this->assertEquals('mysql', $server->database_type);
    }

    // TODO Add tests for validation rules
}
