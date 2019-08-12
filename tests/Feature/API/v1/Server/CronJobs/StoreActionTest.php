<?php

namespace Tests\Feature\API\v1\Server\CronJob;

use App\Scripts\Server\Cron\DeleteJob;
use App\Scripts\Server\Cron\ScheduleJob;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreActionTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_guest_cannot_create_jobs()
    {
        $server = $this->createServer();

        $this->postJson(api_route('server.cron_job.store', $server), [
            'name' => 'test', 'command' => 'apt-get update', 'user' => 'root', 'cron' => '* * * * *',
        ])->assertUnauthorized();
    }

    function test_an_authenticated_user_can_create_jobs_for_own_servers()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $response = $this->postJson(api_route('server.cron_job.store', $server), [
            'name' => 'test', 'command' => 'apt-get update', 'user' => 'root', 'cron' => '* * * * *',
        ])->assertCreated();

        $job = $server->cronJobs()->first();

        $response->assertJson([
            'data' => [
                'name' => $job->name,
                'command' => $job->command,
                'user' => $job->user,
                'cron' => $job->cron,
            ],
        ]);
    }

    function test_an_authenticated_user_cannot_create_jobs_for_foreign_servers()
    {
        $this->signInAPI();
        $server = $this->createServer();

        $this->postJson(api_route('server.cron_job.store', $server), [
            'name' => 'test', 'command' => 'apt-get update', 'user' => 'root', 'cron' => '* * * * *',
        ])->assertForbidden();

        $this->assertCount(0, $server->cronJobs);
    }

    function test_name_is_not_required()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $this->postJson(api_route('server.cron_job.store', $server), [
            'command' => 'apt-get update', 'user' => 'root'
        ])->assertJsonMissingValidationErrors(['name']);
    }

    function test_cron_expression_is_required()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $this->postJson(api_route('server.cron_job.store', $server), [
            'name' => 'test', 'command' => 'apt-get update', 'user' => 'root'
        ])->assertJsonValidationErrors(['cron']);
    }

    function test_cron_expression_must_be_valid()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $this->postJson(api_route('server.cron_job.store', $server), [
            'name' => 'test', 'command' => 'apt-get update', 'user' => 'root', 'cron' => 'test'
        ])->assertJsonValidationErrors(['cron']);
    }

    function test_named_cron_expression_can_be_converted_into_cron_string()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $this->postJson(api_route('server.cron_job.store', $server), [
            'name' => 'test', 'command' => 'apt-get update', 'user' => 'root', 'cron' => '@daily'
        ])->assertJson(['data' => ['cron' => '0 0 * * *']]);
    }

    function test_command_is_required()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $this->postJson(api_route('server.cron_job.store', $server), [
            'name' => 'test', 'user' => 'root'
        ])->assertJsonValidationErrors(['command']);
    }

    function test_user_is_required()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $this->postJson(api_route('server.cron_job.store', $server), [
            'name' => 'test', 'command' => 'apt-get update',
        ])->assertJsonValidationErrors(['user']);
    }

    function test_when_job_is_created_it_should_be_sent_into_remove_server()
    {
        $this->spyRunningTasks();

        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);

        $this->postJson(api_route('server.cron_job.store', $server), [
            'name' => 'test', 'command' => 'apt-get update', 'user' => 'root', 'cron' => '* * * * *',
        ])->assertCreated();

        $job = $server->cronJobs()->first();

        $this->assertExecutedTaskScript(
            new ScheduleJob($job)
        );
    }
}
