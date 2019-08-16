<?php

namespace Tests\Feature\API\v1\Server;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteActionTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_guest_cannot_delete_server()
    {
        $server = $this->createServer();
        $this->deleteJson(api_route('server.delete', $server))->assertUnauthorized();
    }
}
