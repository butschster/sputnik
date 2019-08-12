<?php

namespace Tests\Feature\API\v1\Server\CronJob;

use App\Scripts\Server\Cron\DeleteJob;
use App\Scripts\Server\Cron\ScheduleJob;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreActionTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_guest_cannot_remove_jobs()
    {
        $job = $this->createCronJob();

        $this->deleteJson(api_route('server.cron_job.delete', $job))->assertUnauthorized();
    }

    function test_an_authenticated_user_can_remote_jobs_on_own_servers()
    {
        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);
        $job = $this->createCronJob([
            'server_id' => $server->id
        ]);

        $this->deleteJson(api_route('server.cron_job.delete', $job))->assertDeleted();

        $this->assertCount(0, $server->cronJobs);
    }

    function test_an_authenticated_user_cannot_remove_jobs_on_foreign_servers()
    {
        $user = $this->signInAPI();
        $server = $this->createServer();
        $job = $this->createCronJob([
            'server_id' => $server->id
        ]);

        $this->deleteJson(api_route('server.cron_job.delete', $job))->assertForbidden();

        $this->assertCount(1, $server->cronJobs);
    }

    function test_when_job_is_deleted_it_should_be_removes_from_remove_server()
    {
        $this->spyRunningTasks();

        $user = $this->signInAPI();
        $server = $this->createServer(['user_id' => $user]);
        $job = $this->createCronJob([
            'server_id' => $server->id
        ]);

        $this->deleteJson(api_route('server.cron_job.delete', $job))->assertDeleted();

        $this->assertExecutedTaskScript(
            new DeleteJob($job)
        );
    }
}
