<?php

namespace Tests\Unit\Services\Server;

use App\Events\Task\Running;
use App\Scripts\Server\Cron\DeleteJob;
use App\Scripts\Server\Cron\ScheduleJob;
use App\Services\Server\CronService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CronServiceTaskTest extends TestCase
{
    use DatabaseMigrations;

    function test_validate_string()
    {
        $service = $this->getCronService();

        $this->assertTrue($service->validate('@yearly'));
        $this->assertTrue($service->validate('@annually'));
        $this->assertTrue($service->validate('@monthly'));
        $this->assertTrue($service->validate('@weekly'));
        $this->assertTrue($service->validate('@daily'));
        $this->assertTrue($service->validate('@hourly'));

        $this->assertTrue($service->validate('* * * * *'));
        $this->assertFalse($service->validate('* * * *'));
        $this->assertFalse($service->validate('* * * * * *'));
    }

    function test_a_job_can_be_scheduled_when_it_created()
    {
        $this->spyRunningTasks();

        $job = $this->createCronJob();

        $task = $this->getCronService()->schedule($job);

        $this->assertExecutedTaskScript(
            new ScheduleJob($job)
        );


        $this->assertTaskExecuted($task);
        $this->assertTrue($task->owner->is($job));
        $this->assertTrue($task->server->is($job->server));
    }

    function test_a_job_can_be_deleted_from_server_when_in_was_deleted()
    {
        Event::fake([
            Running::class,
        ]);

        $job = $this->createCronJob();

        $task = $this->getCronService()->delete($job);

        $this->assertExecutedTaskScript(
            new DeleteJob($job)
        );

        $this->assertTaskExecuted($task);
        $this->assertTrue($task->owner->is($job));
        $this->assertTrue($task->server->is($job->server));
    }

    /**
     * @return CronService
     */
    protected function getCronService(): CronService
    {
        return $this->app[CronService::class];
    }
}
