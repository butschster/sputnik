<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ServerInstallerControllerTest extends TestCase
{
    use DatabaseMigrations;

    function test_if_server_has_pending_status_installation_script_can_be_requested()
    {
        $server = $this->createServer();

        $this->get(route('server.install_script', $server))
            ->assertOk()
            ->assertSee('mkdir -p /root/.ssh/authorized_keys.d');
    }

    function test_if_server_has_not_pending_status_installation_script_can_not_be_requested()
    {
        $server = $this->createServer();
        $server->markAsConfiguring();
        $this->get(route('server.install_script', $server))->assertNotFound();

        $server->markAsConfigured();
        $this->get(route('server.install_script', $server))->assertNotFound();
    }
}
