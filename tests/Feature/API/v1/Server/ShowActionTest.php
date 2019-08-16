<?php

namespace Tests\Feature\API\v1\Server;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ShowActionTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_guest_cannot_see_information_about_server()
    {
        $server = $this->createServer();
        $this->getJson(api_route('server.show', $server))->assertUnauthorized();
    }

    function test_an_authenticated_user_cannot_view_information_about_foreign_server()
    {
        $this->signInAPI();
        $server = $this->createServer();

        $response = $this->getJson(api_route('server.show', $server));
        $response->assertForbidden();
    }

    // An authenticated user can view information about own server
    function test_an_authenticated_user_can_view_information_only_about_own_server()
    {
        $user = $this->signInAPI();
        $server = $this->createServer([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson(api_route('server.show', $server));
        $response->assertOk();

        $response->assertJson([
            'data' => [
                'id' => $server->id,
            ],
        ]);
    }
}
