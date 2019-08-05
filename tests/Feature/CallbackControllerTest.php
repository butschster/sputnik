<?php

namespace Tests\Feature;

use App\Jobs\Server\ConfigureServer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class CallbackControllerTest extends TestCase
{
    use DatabaseMigrations;

    function test_received_public_keys_should_be_stored()
    {
        $server = $this->createServer();

        $response = $this->postJson($this->callbackUrl(), [
            'action' => 'server.key',
            'server_id' => $server->id,
            'key' => $publicKey = $this->getPublicKey(),
        ]);

        $response->assertOk();

        $key = $server->keys->first();

        $this->assertEquals($publicKey, $key->content);
    }

    function test_received_public_keys_should_be_ignored()
    {
        $server = $this->createServer();

        $this->postJson($this->callbackUrl(), [
            'action' => 'server.key',
            'server_id' => $server->id,
            'key' => '',
        ])->assertJsonValidationErrors(['key']);

        $this->assertCount(0, $server->keys);
    }

    function test_fire_job_when_keys_installed()
    {
        Bus::fake();

        $server = $this->createServer();

        $this->postJson($this->callbackUrl(), [
            'action' => 'server.keys_installed',
            'server_id' => $server->id,
        ])->assertOk();

        Bus::assertDispatched(ConfigureServer::class);
    }

    function test_if_task_is_not_run_then_disable_update_it()
    {
        $task = $this->createTask();

        $this->postJson($this->callbackUrl(), [
            'action' => 'task.finished',
            'task_id' => $task->id,
            'exit_code' => 0,
        ])->assertStatus(404);

        $task->refresh();

        $this->assertTrue($task->isPending());
    }

    function test_a_task_should_be_finished_when_callback_called()
    {
        $task = $this->createTask();

        $task->markAsRunning();

        $this->postJson($this->callbackUrl(), [
            'action' => 'task.finished',
            'task_id' => $task->id,
            'exit_code' => 0,
        ])->assertOk();

        $task->refresh();

        $this->assertTrue($task->isSuccessful());
        $this->assertTrue($task->isFinished());
    }

    function test_if_action_not_found_show_page_not_found()
    {
        $response = $this->postJson($this->callbackUrl(), [
            'action' => 'non-exist-action-key',
        ]);

        $response->assertStatus(404);
    }

}
