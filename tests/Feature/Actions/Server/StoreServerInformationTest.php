<?php

namespace Tests\Feature\Actions\Server;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreServerInformationTest extends TestCase
{
    use DatabaseMigrations;

    function test_server_id_is_required()
    {
        $this->sendCallbackRequest('server.information', [
            'os' => 'Ubuntu',
            'version' => '18.10',
            'architecture' => '32',
        ])->assertJsonValidationErrors(['server_id']);
    }

    function test_server_should_exist()
    {
        $this->sendCallbackRequest('server.information', [
            'server_id' => 'abs',
            'os' => 'Ubuntu',
            'version' => '18.10',
            'architecture' => '32',
        ])->assertJsonValidationErrors(['server_id']);
    }

    function test_server_should_not_have_os_information()
    {
        $server = $this->createServer([
            'os_information' => [],
        ]);

        $this->sendCallbackRequest('server.information', [
            'server_id' => $server->id,
            'os' => 'Ubuntu',
            'version' => '18.10',
            'architecture' => '32',
        ])->assertJsonValidationErrors(['server_id']);
    }

    function test_os_name_is_required()
    {
        $this->sendCallbackRequest('server.information', [
            'server_id' => 'abs',
            'version' => '18.10',
            'architecture' => '32',
        ])->assertJsonValidationErrors(['os']);
    }

    function test_os_version_is_required()
    {
        $this->sendCallbackRequest('server.information', [
            'server_id' => 'abs',
            'os' => 'Ubuntu',
            'architecture' => '32',
        ])->assertJsonValidationErrors(['version']);
    }

    function test_os_architecture_is_required()
    {
        $this->sendCallbackRequest('server.information', [
            'server_id' => 'abs',
            'os' => 'Ubuntu',
            'version' => '18.10',
        ])->assertJsonValidationErrors(['architecture']);
    }

    function test_valid_information_should_be_stored()
    {
        $server = $this->createServer();

        $this->sendCallbackRequest('server.information', [
            'server_id' => $server->id,
            'os' => 'Ubuntu',
            'version' => '18.10',
            'architecture' => '32',
        ])->assertOk();

        $this->assertEquals([
            'os' => 'Ubuntu',
            'version' => '18.10',
            'architecture' => '32',
        ], $server->refresh()->os_information);
    }

    function test_is_counfiguration_is_not_supportde_mark_server_as_failed()
    {
        config()->set('configurations.os', []);
        $server = $this->createServer();

        $this->sendCallbackRequest('server.information', [
            'server_id' => $server->id,
            'os' => 'Ubuntu',
            'version' => '18.10',
            'architecture' => '32',
        ])->assertOk();

        $this->assertTrue($server->refresh()->isFailed());
    }
}
