<?php

namespace Tests\Unit\Services\Server;

use App\Events\Server\CronJob\Created;
use App\Events\Task\Running;
use App\Services\Server\CronService;
use App\Services\Task\ExecutorService;
use App\Services\Task\Factory;
use App\Utils\SSH\Contracts\ProcessExecutor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CronServiceTaskTest extends TestCase
{
    use DatabaseMigrations;

    function test_validate_string()
    {
        $service = $this->getCronService();

        $this->assertTrue($service->validate('* * * * *'));
    }

    function test_a_job_can_be_scheduled_when_it_created()
    {
        $this->spyRunningTasks();

        $service = $this->getCronService();

        $job = $this->createCronJob();

        $service->schedule($job);

        $this->assertExecutedTaskScriptContains('Schedule new cron job');
        $this->assertExecutedTaskScriptContains($job->crontabName());
    }

    function test_a_job_can_be_deleted_from_server_when_in_was_deleted()
    {
        Event::fake([
            Running::class,
        ]);


        $service = $this->getCronService();

        $job = $this->createCronJob();

        $service->delete($job);

        $this->assertExecutedTaskScriptContains($job->crontabName(), 'Delete scheduled Job');
    }

    /**
     * @param ProcessExecutor $executor
     * @return CronService
     */
    protected function getCronService(ProcessExecutor $executor = null): CronService
    {
        if (!$executor) {
            return $this->app[CronService::class];
        }

        return new CronService(new Factory, new ExecutorService($executor));
    }
}
